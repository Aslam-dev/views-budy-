<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xhtml="https://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd
    https://www.w3.org/1999/xhtml https://www.w3.org/2002/08/xhtml/xhtml1-strict.xsd">

    <url>
        <loc>{{ url('') }}/categories</loc>
        <changefreq>always</changefreq>
        <priority>0.85</priority>
    </url>
    @foreach ($categories as $category)
        <url>
            <loc>{{ url('') }}/category/{{ $category->slug }}</loc>
            <lastmod>{{ $category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>always</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
