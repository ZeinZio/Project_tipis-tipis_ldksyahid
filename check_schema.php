<?php
use Illuminate\Support\Facades\Schema;
echo 'Jumbotron: ' . implode(',', Schema::getColumnListing('jumbotrons')) . "\n";
echo 'Article: ' . implode(',', Schema::getColumnListing('articles')) . "\n";
echo 'News: ' . implode(',', Schema::getColumnListing('news')) . "\n";
echo 'Event: ' . implode(',', Schema::getColumnListing('events')) . "\n";
echo 'Gallery: ' . implode(',', Schema::getColumnListing('galleries')) . "\n";
echo 'Schedule: ' . implode(',', Schema::getColumnListing('schedules')) . "\n";
echo 'Testimony: ' . implode(',', Schema::getColumnListing('testimonies')) . "\n";
echo 'Book: ' . implode(',', Schema::getColumnListing('ms_catalog_books')) . "\n";
