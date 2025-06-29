<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xhtml="https://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd
    https://www.w3.org/1999/xhtml https://www.w3.org/2002/08/xhtml/xhtml1-strict.xsd">

    <url>
        <loc>{{ url('') }}</loc>
        <changefreq>always</changefreq>
        <priority>1.00</priority>
    </url>
    @foreach ($items as $page)
        <url>
            <loc>{{ url('') }}/{{ $page->slug }}</loc>
            <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.85</priority>
        </url>
    @endforeach
    <url>
        <loc>{{ url('') }}/login</loc>
        <changefreq>always</changefreq>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('') }}/register</loc>
        <changefreq>always</changefreq>
        <priority>0.80</priority>
    </url>
</urlset>
