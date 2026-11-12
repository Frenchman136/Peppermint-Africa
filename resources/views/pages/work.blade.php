<x-layouts.app title="Our work"
    description="Conferences, campaigns, documentaries and programmes delivered by Peppermint Africa for government, development partners and private-sector brands."
    headerTheme="dark">

    <x-page-hero eyebrow="Our work" title="Proof of" accent="execution."
        intro="A selection of the events, campaigns and programmes we’ve delivered with government, development partners and private-sector brands." />

    <section class="bg-white py-16 lg:py-24">
        <div class="container-x">
            <livewire:project-filter />
        </div>
    </section>
</x-layouts.app>
