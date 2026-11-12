<?php

namespace App\Livewire;

use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\On;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $organisation = '';
    public string $service = '';
    public string $message = '';

    /** Honeypot: hidden from people, bots tend to fill it in. */
    public string $website = '';

    public bool $sent = false;

    /** 'page' = full form on /contact, 'modal' = compact pop-up form. */
    public string $variant = 'page';

    /** Modal only: reveals the optional phone and organisation fields. */
    public bool $showMore = false;

    public function mount(string $variant = 'page'): void
    {
        $this->variant = $variant;

        // Links like /contact?service=events pre-select a service on the Contact page
        if ($variant === 'page' && ($slug = request()->query('service'))) {
            $this->service = Service::where('slug', $slug)->value('title') ?? '';
        }
    }

    /** Fired by the pop-up each time it opens (see components/contact-modal.blade.php). */
    #[On('prefill-service')]
    public function prefill(string $slug = ''): void
    {
        $this->sent = false;
        $this->resetErrorBag();
        $this->service = $slug ? (Service::where('slug', $slug)->value('title') ?? '') : '';
    }

    public function toggleMore(): void
    {
        $this->showMore = ! $this->showMore;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\-\s]{7,30}$/'],
            'organisation' => ['nullable', 'string', 'max:150'],
            'service' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number.',
            'message.min' => 'Please tell us a little more (at least 10 characters).',
        ];
    }

    public function submit(): void
    {
        $key = 'contact-form:'.request()->ip();

        // Max 3 messages per 10 minutes from one address
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->addError('form', 'You have sent several messages recently. Please try again in a few minutes, or reach us on WhatsApp.');

            return;
        }

        // Bot caught by the honeypot: pretend it worked, store nothing
        if (filled($this->website)) {
            $this->sent = true;

            return;
        }

        $data = $this->validate();

        RateLimiter::hit($key, 600);

        $inquiry = Inquiry::create($data + [
            'status' => 'new',
            'ip_address' => request()->ip(),
        ]);

        // The inquiry is already saved; an email problem must never lose it or show an error.
        try {
            Mail::to(config('site.inquiry_to'))->send(new InquiryReceived($inquiry));
        } catch (\Throwable $e) {
            report($e);
        }

        $this->reset(['name', 'email', 'phone', 'organisation', 'service', 'message', 'website']);
        $this->sent = true;
    }

    public function sendAnother(): void
    {
        $this->sent = false;
    }

    public function render()
    {
        return view('livewire.contact-form', [
            'services' => Service::orderBy('sort_order')->get(),
        ]);
    }
}
