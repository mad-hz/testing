<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Observers\ArticleObserver;
use App\Notifications\ArticleMention;
use Illuminate\Database\Eloquent\Model;
use App\Models\traits\HasValidationRequests;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy(ArticleObserver::class)]
class Article extends Model
{
    use HasFactory;
    use HasValidationRequests;
    use PivotEventTrait;

    protected $fillable = [
        'author_id',
        'title',
        'content',
        'image'
    ];

    /**
//     * User who had created the article
//     * @return BelongsTo
//     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all the HTML headings (h1 to h6) from the content
     * and return them as an array
     *
     * This is used to generate the navigation based on the headings in the article content.
     *
     * @return Attribute
     */
    protected function headings(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Create a new DOMDocument to parse the HTML content
                $dom = new \DOMDocument();

                // Suppress warnings from malformed HTML
                libxml_use_internal_errors(true);

                // Load the content with UTF-8 encoding hint
                $dom->loadHTML('<?xml encoding="utf-8" ?>' . $this->content);

                // Clear any errors after loading
                libxml_clear_errors();

                $headings = [];

                // Loop through all heading tags h1 to h6
                foreach (['h1', 'h2', 'h3', 'h4', 'h5', 'h6'] as $tag) {
                    // Find all nodes with this tag
                    foreach ($dom->getElementsByTagName($tag) as $node) {
                        $text = $node->textContent;           // Extract heading text
                        $slug = Str::slug($text);             // Create a URL-friendly slug
                        $headings[] = ['text' => $text, 'slug' => $slug];  // Save it
                    }
                }

                return $headings;
            }
        );
    }

    /**
     * Returns the content with heading tags
     * modified to include an 'id' attribute based on their slug.
     *
     * Adding id's to the elements allows linking directly to headings in the page.
     *
     * @return Attribute
     */
    protected function contentWithIds(): Attribute
    {
        return Attribute::make(
            get: function () {
                $dom = new \DOMDocument();

                libxml_use_internal_errors(true);

                $dom->loadHTML('<?xml encoding="utf-8" ?>' . $this->content);

                libxml_clear_errors();

                // Loop through all heading tags and add an 'id' attribute
                foreach (['h1', 'h2', 'h3', 'h4', 'h5', 'h6'] as $tag) {
                    foreach ($dom->getElementsByTagName($tag) as $node) {
                        $text = $node->textContent;
                        $slug = \Str::slug($text);
                        $node->setAttribute('id', $slug);  // Set id attribute for anchor links
                    }
                }

                // Return the modified HTML content as a string
                return $dom->saveHTML();
            }
        );
    }

    /**
     * Detectes if an article mention gets attached
     */
    public static function booted()
    {
        static::pivotAttached(function ($model, $relationName, $pivotIds) {
            if ($relationName == 'mentions') {
                User::find($pivotIds)->each->notify(new ArticleMention($model));
            }
        });
    }

    /**
     * A relationship of mentions between an article and a user
     */
    public function mentions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'articles_mentions')
            ->withTimestamps();
    }
}
