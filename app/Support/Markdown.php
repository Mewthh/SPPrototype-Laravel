<?php

namespace App\Support;

use Illuminate\Support\Str;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\Table\TableExtension;

class Markdown
{
    /**
     * Parse rich markdown content into HTML with all requested extensions.
     */
    public static function render(?string $content): string
    {
        if ($content === null || $content === '') {
            return '';
        }

        // Custom inline syntax conversions before CommonMark
        // Highlight ==text== -> <mark>text</mark>
        $processed = preg_replace('/==([^=\n]+)==/', '<mark>$1</mark>', $content);

        // Underline ++text++ -> <u>$1</u>
        $processed = preg_replace('/\+\+([^\+\n]+)\+\+/', '<u>$1</u>', $processed);

        // Subscript ~text~ (single tilde, avoiding double ~~strikethrough~~)
        $processed = preg_replace('/(?<!~)(?<!\\\\)~([^~\n]+)~(?!~)/', '<sub>$1</sub>', $processed);

        // Superscript ^text^
        $processed = preg_replace('/(?<!\^)(?<!\\\\)\^([^\^\n]+)\^(?!\^)/', '<sup>$1</sup>', $processed);

        return (string) Str::markdown(
            $processed,
            [
                'renderer' => [
                    'soft_break' => "<br>\n",
                ],
                'html_input' => 'allow',
                'allow_unsafe_links' => false,
            ],
            [
                new TableExtension,
                new FootnoteExtension,
            ]
        );
    }

    /**
     * Parse inline markdown for titles and excerpts.
     */
    public static function renderInline(?string $content): string
    {
        if ($content === null || $content === '') {
            return '';
        }

        $processed = preg_replace('/==([^=\n]+)==/', '<mark>$1</mark>', $content);
        $processed = preg_replace('/\+\+([^\+\n]+)\+\+/', '<u>$1</u>', $processed);
        $processed = preg_replace('/(?<!~)(?<!\\\\)~([^~\n]+)~(?!~)/', '<sub>$1</sub>', $processed);
        $processed = preg_replace('/(?<!\^)(?<!\\\\)\^([^\^\n]+)\^(?!\^)/', '<sup>$1</sup>', $processed);

        return (string) Str::inlineMarkdown(
            $processed,
            [
                'html_input' => 'allow',
                'allow_unsafe_links' => false,
            ]
        );
    }
}
