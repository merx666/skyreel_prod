<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\Job;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap for the website';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Add static pages
        $sitemap->add(Url::create(route('home'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0));

        // Legal pages
        $sitemap->add(Url::create(route('legal.privacy-policy'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.5));
        $sitemap->add(Url::create(route('legal.terms-of-service'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.5));

        $sitemap->add(Url::create(route('jobs.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.9));

        $sitemap->add(Url::create(route('profiles.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.9));

        $sitemap->add(Url::create(route('portfolios.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.85));

        // Add operator profiles
        User::where('role', 'operator')
            ->whereHas('profile')
            ->with('profile')
            ->chunk(100, function ($operators) use ($sitemap) {
                foreach ($operators as $operator) {
                    $sitemap->add(Url::create(route('profile.show', $operator))
                        ->setLastModificationDate($operator->profile->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.7));
                }
            });

        // Add portfolios
        Portfolio::with('user')
            ->chunk(100, function ($portfolios) use ($sitemap) {
                foreach ($portfolios as $portfolio) {
                    $sitemap->add(Url::create(route('portfolios.show', $portfolio))
                        ->setLastModificationDate($portfolio->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.6));
                }
            });

        // Add open jobs
        Job::where('status', 'open')
            ->chunk(100, function ($jobs) use ($sitemap) {
                foreach ($jobs as $job) {
                    $sitemap->add(Url::create(route('jobs.show', $job))
                        ->setLastModificationDate($job->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.8));
                }
            });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }
}