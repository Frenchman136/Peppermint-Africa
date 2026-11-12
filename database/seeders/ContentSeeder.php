<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Loads the services, industries and portfolio from config/content.php into the database.
 * Safe to run more than once: existing records are left untouched (so admin edits are never overwritten).
 *
 *   php artisan db:seed --class=ContentSeeder
 */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->copyPlaceholderMedia();

        $services = [];
        foreach (config('content.services') as $i => $s) {
            $services[$s['slug']] = Service::firstOrCreate(['slug' => $s['slug']], [
                'title' => $s['title'],
                'description' => $s['description'],
                'includes' => $s['includes'] ?? [],
                'sort_order' => $i,
            ]);
        }

        $industries = [];
        foreach (config('content.industries') as $i => $name) {
            $industries[$name] = Industry::firstOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'sort_order' => $i,
            ]);
        }

        // Project title => [service slug, industry name]. Adjust any of these in the admin later.
        $map = [
            '1st National Mango Conference, Kenya' => ['events', 'Government & Public Institutions'],
            'FLOCCA Project: Documentary & Publications' => ['digital-content', 'NGOs & Development Organisations'],
            '7th Annual Devolution Conference' => ['digital-content', 'Government & Public Institutions'],
            'Commercial Radio Station Setup' => ['project-management', 'Corporate & Private Sector'],
            'Digital Communications & Marketing' => ['digital-content', 'Hospitality & Tourism'],
            'Campaign Materials Branding' => ['brand-strategy', null],
        ];

        foreach (config('content.projects') as $i => $p) {
            [$serviceSlug, $industryName] = $map[$p['title']] ?? [null, null];

            $cover = $p['image'] ? 'projects/'.$p['image'] : null;
            $gallery = collect($p['gallery'] ?? [])->map(fn ($f) => 'projects/'.$f)->all() ?: null;

            $project = Project::firstOrCreate(['slug' => Str::slug($p['title'])], [
                'title' => $p['title'],
                'client' => $p['client'],
                'service_id' => $serviceSlug ? $services[$serviceSlug]->id : null,
                'industry_id' => $industryName ? $industries[$industryName]->id : null,
                'summary' => $p['summary'],
                'cover_image' => $cover,
                'gallery' => $gallery,
                'is_featured' => $p['featured'],
                'is_published' => $p['public'],
                'sort_order' => $i,
            ]);

            // Projects created before the placeholder images existed get them too, but only where empty
            // (real photos uploaded in the admin are never overwritten).
            if (blank($project->cover_image) && $cover) {
                $project->update(['cover_image' => $cover]);
            }
            if (blank($project->gallery) && $gallery) {
                $project->update(['gallery' => $gallery]);
            }
        }

        foreach (config('content.clients') as $i => $name) {
            Client::firstOrCreate(['name' => $name], ['sort_order' => $i]);
        }

        $this->seedAlbums();
        $this->seedSamplePosts();
    }

    /** Placeholder photo albums (abstract artwork). Replace the photos in the admin: Gallery > Albums. */
    private function seedAlbums(): void
    {
        $albums = [
            ['title' => '1st National Mango Conference', 'key' => 'mango', 'description' => 'Moments from the conference.'],
            ['title' => 'FLOCCA Documentary', 'key' => 'flocca', 'description' => 'Behind the scenes on the documentary shoot.'],
            ['title' => 'Devolution Conference', 'key' => 'devolution', 'description' => 'Highlights from the 7th Annual Devolution Conference.'],
            ['title' => 'ENE FM Setup', 'key' => 'enefm', 'description' => 'Building a commercial radio station.'],
            ['title' => 'Digital Campaigns', 'key' => 'digital', 'description' => 'Social and content work for hospitality brands.'],
        ];

        foreach ($albums as $i => $a) {
            Album::firstOrCreate(['slug' => Str::slug($a['title'])], [
                'title' => $a['title'],
                'description' => $a['description'],
                'photos' => collect(['cover', '1', '2', '3'])->map(fn ($n) => 'projects/'.$a['key'].'-'.$n.'.webp')->all(),
                'is_published' => true,
                'sort_order' => $i,
            ]);
        }
    }

    /**
     * SAMPLE blog posts so you can see the Blog design. They are generic advice, not company news.
     * Edit, replace or delete them in the admin (Blog > Posts) before launch.
     */
    private function seedSamplePosts(): void
    {
        $posts = [
            [
                'title' => 'How to plan a conference people remember',
                'category' => 'Events',
                'cover' => 'projects/blog-1.webp',
                'excerpt' => 'Great events are decided long before doors open. Four planning habits that keep stakeholders, speakers and guests on the same page.',
                'body' => <<<'MD'
A memorable conference is rarely about the budget. It is about clarity: knowing who the event is for, what each person should walk away with, and how every detail supports that.

## Start with the audience, not the venue

Before booking a space, write down the three groups who matter most (for example funders, partners and the public) and one outcome you want for each. Every later decision, from the agenda to the seating plan, can be tested against that list.

## Map your stakeholders early

Events involving government, development partners and private sponsors have many voices. Agree who approves what, and by when. A simple one-page approvals chart saves days of back and forth in the final week.

## Build the run of show like a story

Think about energy across the day. Place the strongest content when people are freshest, leave breathing room between sessions, and give the closing moment a clear purpose.

## Plan the after-event before the event

Photos, video clips, a short summary and a thank-you note are most useful when they are planned in advance, not rushed afterwards. Decide what you will capture and who will publish it.

**The takeaway:** treat the event as a communication project with a start, a middle and an end that continues after the last guest leaves.
MD,
            ],
            [
                'title' => 'Five questions to ask before launching a PR campaign',
                'category' => 'Public Relations',
                'cover' => 'projects/blog-2.webp',
                'excerpt' => 'A campaign without a clear answer to these questions usually costs more and says less. Use this short list before you brief anyone.',
                'body' => <<<'MD'
Media attention is easy to chase and hard to measure. These five questions help you decide what you really want from a campaign.

## 1. What single message should people remember?

If you need three sentences to explain it, keep editing. One clear idea travels further than five.

## 2. Who needs to hear it first?

List the audiences in order of importance. Journalists, regulators, customers and employees often need different framing of the same news.

## 3. Why would a journalist care?

News is about people, change and impact. Find the human angle or the number that makes your story worth a headline.

## 4. Who is the best voice?

The right spokesperson is prepared, credible and comfortable with tough questions. Invest in briefing them well.

## 5. How will we know it worked?

Agree on two or three measures before launch, such as quality of coverage, audience reach, or actions taken after the story. Review them honestly afterwards.

**Final thought:** the best campaigns are simple, specific and prepared for the questions that will inevitably follow.
MD,
            ],
            [
                'title' => 'Why measuring communication matters (and what to track)',
                'category' => 'Strategy',
                'cover' => 'projects/blog-3.webp',
                'excerpt' => 'Numbers do not replace judgement, but they do show where your message is landing. A practical way to choose metrics that matter.',
                'body' => <<<'MD'
It is tempting to report everything you can count. A better approach is to track the few measures that connect directly to your goals.

## Start from the goal

Different goals need different measures. Awareness might look at reach and mentions. Engagement might look at attendance, enquiries or shares. Behaviour change might look at sign-ups or visits to a service.

## Choose a small set

Two or three well-chosen indicators beat a long dashboard nobody reads. Make sure each one can be collected reliably and repeated each month.

## Mix numbers and stories

Quotes from participants, photos and short case notes bring numbers to life. Together they show both scale and meaning.

## Use results to improve

Review what worked at set points during a campaign, not only at the end. Small adjustments, such as changing a headline or timing, can lift results while there is still time.

**In short:** measurement is not paperwork. It is how a communication team keeps learning.
MD,
            ],
        ];

        foreach ($posts as $i => $p) {
            Post::firstOrCreate(['slug' => Str::slug($p['title'])], [
                'title' => $p['title'],
                'category' => $p['category'],
                'excerpt' => $p['excerpt'],
                'body' => $p['body'],
                'cover_image' => $p['cover'],
                'author_name' => 'Peppermint Africa Team',
                'published_at' => Carbon::now()->subDays(($i + 1) * 9),
                'is_published' => true,
                'is_featured' => $i === 0,
            ]);
        }
    }

    /** Copies the bundled placeholder artwork into the public storage disk (what the admin uploads use). */
    private function copyPlaceholderMedia(): void
    {
        foreach (glob(database_path('seeders/media/*.webp')) ?: [] as $file) {
            $target = 'projects/'.basename($file);

            if (! Storage::disk('public')->exists($target)) {
                Storage::disk('public')->put($target, file_get_contents($file));
            }
        }
    }
}
