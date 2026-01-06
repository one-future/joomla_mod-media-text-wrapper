<?php
    /**
     * Helper class for Media & Text module
     * 
     * @link http://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
     * @license        GNU/GPL, see LICENSE.php
     * mod_helloworld is free software. This version may have been modified pursuant
     * to the GNU General Public License, and as distributed it includes or
     * is derivative of works licensed under the GNU General Public License or
     * other free or open source software licenses.
     */

    class ModMediaTextHelper {
        public static function getHello(&$params) {
            return "Hello";
        }
    }

    class OutputBuilder
    {
        private $moduleID;

        function __construct($id) {
            $this->moduleID = $id;
        }

        public function buildImageContainer(&$params) {
            return "<img class=\"lazyload\" data-src=\"" . $params->get('image') . "\">";
        }

        public function buildCustomVideoContainer(&$params) {
            $videoheight = $params->get('video_height');
            $videowidth = $params->get('video_width');

            return "<div class=\"mediatext-videowrapper-" . $this->moduleID . "\" style=\"padding-top:" . ($videoheight / $videowidth * 100) . "%;\">
                        <iframe class=\"mediatext-video-" . $this->moduleID . "\" src=\"" . $params->get('video') . "\"></iframe>
                    </div>";
        }

        private function buildFacebookVideoContainer($url, $width, $height, $fullscreen, $autoplay, $text, $captions) {
            return " 
            <div class=\"mediatext-videowrapper-" . $this->moduleID . "\" style=\"padding-top:" . ($height / $width * 100) . "%;\">
                <iframe class=\"lazyload mediatext-video-" . $this->moduleID . "\" 
                    data-src=\"" . $url . "\" 
                    width=\"" . $width . "\" 
                    height=\"" . $height . "\" 
                    style=\"border:none;overflow:hidden\" 
                    scrolling=\"no\" 
                    frameborder=\"0\" 
                    allowTransparency=\"true\" 
                    allow=\"encrypted-media\" 
                    allowFullScreen=\"" . ($fullscreen == 1 ? "allowfullscreen" : "") . "\">
                </iframe>
            </div>
            ";
        }

        private function buildYoutubeVideoContainer($url, $width, $height, $fullscreen, $autoplay, $acc, $gyro, $enc, $pip) {

            return " 
            <div class=\"mediatext-videowrapper-" . $this->moduleID . "\" style=\"padding-top:" . ($height / $width * 100) . "%;\">
                <iframe class=\"lazyload mediatext-video-" . $this->moduleID . " mediatext_yt-video\"
                data-src=\"" . $url . "\"
                width=\"" . $width . "\" 
                height=\"" . $height . "\"  
                frameborder=\"0\" 
                referrerpolicy=\"strict-origin-when-cross-origin\"
                allow=\"" . ($acc == 1 ? "accelerometer;" : "") . " " . ($autoplay == 1 ? "autoplay;" : "") . " " . ($enc == 1 ? "encrypted-media;" : "") . " " . ($gyro == 1 ? "gyroscope;" : "") . " " . ($pip == 1 ? "picture-in-picture;" : "") . "\" 
                " . ($fullscreen == 1 ? "allowfullscreen" : "") . ">
                </iframe>
            </div>
            ";
        }

        public function buildOutput(&$p, $media_type) {
            $htmlstring="";

            if($media_type == "custom_video") {
                //Custom Video
                $htmlstring = $this->buildCustomVideoContainer($p);
                    
            } elseif ($media_type == "fb_video") { 
                //Facebook Video
                $htmlstring = $this->buildFacebookVideoContainer($p->get('video'), $p->get('facebook_width'), $p->get('facebook_height'), $p->get('facebook_fullscreen'), $p->get('facebook_autoplay'), $p->get('facebook_text'), $p->get('facebook_captions'));

            } elseif($media_type == "yt_video") {
                //Youtube Video
                $htmlstring = $this->buildYoutubeVideoContainer($p->get('video'), $p->get('yt_width'), $p->get('yt_height'), $p->get('yt_fullscreen'), $p->get('yt_autoplay'), $p->get('yt_accelerometer'), $p->get('yt_gyroscope'), $p->get('yt_encrypted'), $p->get('yt_pip'));

            } elseif ($media_type == "image") {
                //Image
                $htmlstring = $this->buildImageContainer($p);

            } else {
                $htmlstring = "Error finding media to display.";
            }

            return $htmlstring;
        }
    }

?>