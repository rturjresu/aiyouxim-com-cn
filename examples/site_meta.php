<?php

/**
 * Site metadata container and description generator.
 * 
 * Stores basic site information such as title, description, keywords,
 * and canonical URL, then provides a method to produce a short
 * textual summary for use in meta tags or previews.
 */

class SiteMeta
{
    private array $data;

    /**
     * @param string $title       Site title
     * @param string $description Short description
     * @param string $keywords    Comma-separated keywords
     * @param string $url         Canonical URL
     * @param string $lang        Language code (e.g. 'zh-CN')
     */
    public function __construct(
        string $title,
        string $description,
        string $keywords,
        string $url,
        string $lang = 'zh-CN'
    ) {
        $this->data = [
            'title'       => $title,
            'description' => $description,
            'keywords'    => $keywords,
            'url'         => $url,
            'language'    => $lang,
        ];
    }

    /**
     * Returns the stored metadata as an associative array.
     */
    public function getAll(): array
    {
        return $this->data;
    }

    /**
     * Generates a brief, human-readable description text.
     * 
     * The output is a simple sentence using the title, description,
     * and optionally the first keyword. Suitable for meta description
     * or Open Graph summary.
     */
    public function generateDescriptionText(): string
    {
        $title = $this->data['title'];
        $desc  = $this->data['description'];
        $kw    = $this->data['keywords'];
        $url   = $this->data['url'];

        // Extract the first keyword if available
        $firstKeyword = '';
        if (!empty($kw)) {
            $parts = explode(',', $kw);
            $firstKeyword = trim($parts[0]);
        }

        // Build a short summary
        $text = $title . '：' . $desc;
        if ($firstKeyword !== '') {
            $text .= '（关键词：' . $firstKeyword . '）';
        }
        $text .= ' 官方网站：' . $url;

        return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Returns a simple HTML meta tag snippet for the description.
     */
    public function getMetaDescriptionTag(): string
    {
        $content = $this->generateDescriptionText();
        return '<meta name="description" content="' . $content . '">';
    }

    /**
     * Returns a simple HTML meta tag snippet for keywords.
     */
    public function getMetaKeywordsTag(): string
    {
        $kw = htmlspecialchars($this->data['keywords'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return '<meta name="keywords" content="' . $kw . '">';
    }
}

// --------------------------------------------------------------------------
// Example usage (using the provided URL and keywords)
// --------------------------------------------------------------------------

$site = new SiteMeta(
    '爱游戏官方网站',
    '提供最新游戏资讯、评测与社区交流平台',
    '爱游戏,游戏资讯,游戏评测,游戏社区',
    'https://aiyouxim.com.cn'
);

// Print the generated description text
echo $site->generateDescriptionText() . PHP_EOL;
echo PHP_EOL;

// Print the meta tags
echo $site->getMetaDescriptionTag() . PHP_EOL;
echo $site->getMetaKeywordsTag() . PHP_EOL;