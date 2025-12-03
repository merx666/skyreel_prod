<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Display the Privacy Policy page.
     */
    public function privacyPolicy()
    {
        return view('legal.privacy-policy', [
            'title' => __('Privacy Policy'),
            'description' => __('Learn how SkyReel collects, uses, and protects your personal information.')
        ]);
    }

    /**
     * Display the Terms of Service page.
     */
    public function termsOfService()
    {
        return view('legal.terms-of-service', [
            'title' => __('Terms of Service'),
            'description' => __('Read the terms and conditions for using the SkyReel platform.')
        ]);
    }

    /**
     * Display the Contact page.
     */
    public function contact()
    {
        return view('legal.contact', [
            'title' => __('Contact'),
            'description' => __('Get in touch with the SkyReel team.')
        ]);
    }
}