<?php

use App\Constants\Constant;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\Language;
use App\Models\Page;
use App\Models\User;
use App\Models\User\Advertisement;
use App\Models\User\BasicSetting;
use App\Models\User\Page as UserPage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {

                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;
    }
}


if (!function_exists('replaceBaseUrl')) {
    function replaceBaseUrl($html)
    {
        $startDelimiter = 'src="';
        $endDelimiter = public_path('assets/front/img/summernote/');
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($html, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($html, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $html = substr_replace($html, url('/'), $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }
        return $html;
    }
}

if (!function_exists('setAwsCredentials')) {
    function setAwsCredentials($key,$secret,$region,$bucket)
    {
        config([
            'filesystems.disks.s3.key' => $key,
            'filesystems.disks.s3.secret' => $secret,
            'filesystems.disks.s3.region' => $region,
            'filesystems.disks.s3.bucket' => $bucket,
        ]);
    }
}


if (!function_exists('convertUtf8')) {
    function convertUtf8($value)
    {
        if (!empty($value)) {
            return mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8' ? $value : mb_convert_encoding($value, 'UTF-8');
        } else {
            return null;
        }
    }
}


if (!function_exists('make_slug')) {
    function make_slug($string)
    {
        $slug = preg_replace('/\s+/u', '-', trim($string));
        $slug = str_replace("/", "", $slug);
        $slug = str_replace("?", "", $slug);
        return mb_strtolower($slug, 'UTF-8');
    }
}


if (!function_exists('make_input_name')) {
    function make_input_name($string)
    {
        return preg_replace('/\s+/u', '_', trim($string));
    }
}

if (!function_exists('hasCategory')) {
    function hasCategory($version)
    {
        if (strpos($version, "no_category") !== false) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('isDark')) {
    function isDark($version)
    {
        if (strpos($version, "dark") !== false) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('slug_create')) {
    function slug_create($val)
    {
        $slug = preg_replace('/\s+/u', '-', trim($val));
        $slug = str_replace("/", "", $slug);
        $slug = str_replace("?", "", $slug);
        return mb_strtolower($slug, 'UTF-8');
    }
}

if (!function_exists('hex2rgb')) {
    function hex2rgb($colour)
    {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array('red' => $r, 'green' => $g, 'blue' => $b);
    }
}


if (!function_exists('getHref')) {
    function getHref($link)
    {
        $href = "#";
        if ($link["type"] == 'home') {
            $href = route('front.index');
        } else if ($link["type"] == 'listings') {
            $href = route('front.user.view');
        } else if ($link["type"] == 'pricing') {
            $href = route('front.pricing');
        } else if ($link["type"] == 'faq') {
            $href = route('front.faq.view');
        } else if ($link["type"] == 'blog') {
            $href = route('front.blogs');
        } else if ($link["type"] == 'contact') {
            $href = route('front.contact');
        } else if ($link["type"] == 'custom') {
            if (empty($link["href"])) {
                $href = "#";
            } else {
                $href = $link["href"];
            }
        } else {
            $pageid = (int)$link["type"];
            $page = Page::find($pageid);
            if (!empty($page)) {
                $href = route('front.dynamicPage', [$page->slug]);
            }
        }
        return $href;
    }
}
if (!function_exists('getUserHref')) {
    function getUserHref($link, $langId)
    {
        $user = getUser();
        if ($link["type"] == 'home') {
            $href = route('front.user.detail.view', getParam());
        }else if ($link["type"] == 'courses') {
            $href = route('front.user.courses', getParam());
        } else if ($link["type"] == 'instructors') {
            $href = route('front.user.instructors', getParam());
        } else if ($link["type"] == 'blog') {
            $href = route('front.user.blogs', getParam());
        } else if ($link["type"] == 'contact') {
            $href = route('front.user.contact', getParam());
        } else if ($link["type"] == 'faq') {
            $href = route('front.user.faq', getParam());
        }else if ($link["type"] == 'custom') {
            if (empty($link["href"])) {
                $href = "#";
            } else {
                $href = $link["href"];
            }
        }
        else {
            $page_id = (int)$link["type"];
            $page = User\CustomPage\Page::query()->where('user_id', $user->id)->find($page_id);
            $content = User\CustomPage\PageContent::query()
                ->where('user_id', $user->id)
                ->where('page_id', $page->id)
                ->where('language_id', $langId)->first();
            if (!empty($content)) {
                $href = route('front.user.cpage', [getParam(), $content->slug]);
            } else {
                $href = "#";
            }
        }
        return $href;
    }
}


if (!function_exists('create_menu')) {
    function create_menu($arr)
    {
        echo '<ul class="sub-menu">';
        foreach ($arr["children"] as $el) {
            // determine if the class is 'submenus' or not
            $class = 'class="nav-item"';
            if (array_key_exists("children", $el)) {
                $class = 'class="nav-item submenus"';
            }
            // determine the href
            $href = getHref($el);
            echo '<li ' . $class . '>';
            echo '<a  href="' . $href . '" target="' . $el["target"] . '">' . $el["text"] . '</a>';
            if (array_key_exists("children", $el)) {
                create_menu($el);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}


if (!function_exists('format_price')) {
    function format_price($value): string
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))
                                    ->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $bex = $currentLang->basic_extended;
        if ($bex->base_currency_symbol_position == 'left') {
            return $bex->base_currency_symbol . $value;
        } else {
            return $value . $bex->base_currency_symbol;
        }
    }
}

// checks if 'current package has subdomain ?'

if (!function_exists('cPackageHasSubdomain')) {
    function cPackageHasSubdomain($user): bool
    {
        $currPackageFeatures = UserPermissionHelper::packagePermission($user->id);
        $currPackageFeatures = json_decode($currPackageFeatures, true);

        // if the current package does not contain subdomain
        if (empty($currPackageFeatures) || !is_array($currPackageFeatures) || !in_array('Subdomain', $currPackageFeatures)) {
            return false;
        }
        return true;
    }
}


// checks if 'current package has custom domain ?'
if (!function_exists('cPackageHasCdomain')) {
    function cPackageHasCdomain($user): bool
    {
        $currPackageFeatures = UserPermissionHelper::packagePermission($user->id);
        $currPackageFeatures = json_decode($currPackageFeatures, true);
        if (empty($currPackageFeatures) || !is_array($currPackageFeatures) || !in_array('Custom Domain', $currPackageFeatures)) {
            return false;
        }
        return true;
    }
}

if (!function_exists('getCdomain')) {

    function getCdomain($user)
    {
        $cdomains = $user->custom_domains()->where('status', 1);
        return $cdomains->count() > 0 ? $cdomains->orderBy('id', 'DESC')->first()->requested_domain : false;
    }
}

if (!function_exists('getUser')) {

    function getUser()
    {
        $parsedUrl = parse_url(url()->current());
        
        $host =  $parsedUrl['host'];

        // if the current URL contains the website domain
        if (strpos($host, env('WEBSITE_HOST')) !== false) {
            $host = str_replace('www.', '', $host);
            // if current URL is a path based URL
            if ($host == env('WEBSITE_HOST')) {
                $path = explode('/', $parsedUrl['path']);
                $username = $path[1];
            } 
            // if the current URL is a subdomain
            else {
                $hostArr = explode('.', $host);
                $username = $hostArr[0];
            }
            
            if(($host == $username . '.' . env('WEBSITE_HOST')) || ($host . '/' . $username == env('WEBSITE_HOST') . '/' . $username)) {
                $user = User::where('username', $username)
                ->where('online_status', 1)
                ->where('status', 1)
                ->whereHas('memberships', function($q){
                    $q->where('status','=',1)
                    ->where('start_date','<=', Carbon::now()->format('Y-m-d'))
                    ->where('expire_date', '>=', Carbon::now()->format('Y-m-d'));
                })
                ->firstOrFail();
    
                // if the current url is a subdomain
                if ($host != env('WEBSITE_HOST')) {
                    if (!cPackageHasSubdomain($user)) {
                        return view('errors.404');
                    }
                }
                
                return $user;
            }
        } 
        
        // Always include 'www.' at the begining of host
        if (substr($host, 0, 4) == 'www.') {
            $host = $host;
        } else {
            $host = 'www.' . $host;
        }
        
        $user = User::where('online_status', 1)
        ->whereHas('user_custom_domains', function($q) use ($host) {
            $q->where('status','=',1)
            ->where(function ($query) use ($host) {
               $query->where('requested_domain','=',$host)
                ->orWhere('requested_domain','=',str_replace("www.","",$host));
            });
            // fetch the custom domain , if it matches 'with www.' URL or 'without www.' URL
        })
        ->whereHas('memberships', function($q){
            $q->where('status','=',1)
            ->where('start_date','<=', Carbon::now()->format('Y-m-d'))
            ->where('expire_date', '>=', Carbon::now()->format('Y-m-d'));
        })->firstOrFail();

        if (!cPackageHasCdomain($user)) {
            return view('errors.404');
        }
        
        return $user;
        
    }
}

if (!function_exists('getParam')) {

    function getParam()
    {
        $parsedUrl = parse_url(url()->current());
        $host = str_replace("www.","",$parsedUrl['host']);
        // if it is path based URL, then return {username}
        if (strpos($host, env('WEBSITE_HOST')) !== false && $host == env('WEBSITE_HOST')) {
            $path = explode('/', $parsedUrl['path']);
            return $path[1];
        }
        // if it is a subdomain / custom domain , then return the host (username.domain.ext / custom_domain.ext)
        return $host;

    }
}
if (!function_exists('detailsUrl')) {

    function detailsUrl($user)
    {
        $currentUrl = url('/');
        $url = str_replace('https:','', $currentUrl);
        $url = str_replace('http:','', $url);
        return $url . '/' . $user->username;
    }
}

if (!function_exists('showAd')) {
    function showAd($resolutionType)
    {
        $user = getUser();
        $ad = Advertisement::query()
            ->where('resolution_type', $resolutionType)
            ->where('user_id', $user->id)
            ->inRandomOrder()
            ->first();
        $bs = User\BasicSetting::query()
            ->where('user_id', $user->id)
            ->first();

        if (!is_null($ad)) {
            if ($resolutionType == 1) {
                $maxWidth = '300px';
                $maxHeight = '250px';
            } else if ($resolutionType == 2) {
                $maxWidth = '300px';
                $maxHeight = '600px';
            } else {
                $maxWidth = '728px';
                $maxHeight = '90px';
            }

            if ($ad->ad_type == 'banner') {
                return '<a href="' . url($ad->url) . '" target="_blank" onclick="adView(' . $ad->id . ')">
                            <img src="' . \App\Http\Helpers\Uploader::getImageUrl(Constant::WEBSITE_ADVERTISEMENT_IMAGE,$ad->image,$bs) . '" alt="advertisement" style="max-width: 100%;">
                        </a>';
            } else {
                return "<script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=" . $bs->google_adsense_publisher_id . "'
        crossorigin='anonymous'></script>
        <ins class='adsbygoogle'
              style='display:block'
              data-ad-client='" . $bs->adsense_publisher_id . "'
              data-ad-slot='" . $ad->ad_slot . "'
              data-ad-format='auto'
              data-full-width-responsive='true'></ins>
        <script>
              (adsbygoogle = window.adsbygoogle || []).push({});
        </script>";
            }
        } else {
            return;
        }
    }
}

