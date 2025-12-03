<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portfolio;
use App\Models\Job;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // Add static pages
        $sitemap->add(Url::create(route('home'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0));

        $sitemap->add(Url::create(route('profiles.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.9));

        $sitemap->add(Url::create(route('jobs.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.9));

        // Portfolios index
        $sitemap->add(Url::create(route('portfolios.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.85));

        // Marketing pages
        $sitemap->add(Url::create(route('pages.uslugi'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8));

        $sitemap->add(Url::create(route('pages.o-nas'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.7));

        $sitemap->add(Url::create(route('pages.kontakt'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.7));

        // Add operator profiles
        User::where('role', 'operator')
            ->whereHas('profile')
            ->with('profile')
            ->chunk(100, function ($operators) use ($sitemap) {
                foreach ($operators as $operator) {
                    // Public user profile route
                    $sitemap->add(Url::create(route('profile.show', $operator))
                        ->setLastModificationDate($operator->profile->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8));
                }
            });

        // Add portfolios
        Portfolio::with('user')
            ->chunk(100, function ($portfolios) use ($sitemap) {
                foreach ($portfolios as $portfolio) {
                    $sitemap->add(Url::create(route('portfolios.show', $portfolio->slug))
                        ->setLastModificationDate($portfolio->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.7));
                }
            });

        // Add open jobs
        Job::where('status', 'open')
            ->chunk(100, function ($jobs) use ($sitemap) {
                foreach ($jobs as $job) {
                    $sitemap->add(Url::create(route('jobs.show', $job))
                        ->setLastModificationDate($job->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.6));
                }
            });

        return response($sitemap->render(), 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
}