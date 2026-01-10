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

    class OutputBuilder
    {
        private $moduleID;

        function __construct($id) {
            $this->moduleID = $id;
        }

        public function buildImageContainer(&$params) {
            if ($this->lazyload) {
                return "<img class=\"lazyload\" data-src=\"" . $params->get('image') . "\">";
            }
            return "<img src=\"" . $params->get('image') . "\">"; 
        }

        private function buildEmbeddedVideoContainer($params) {
            $doc = new DOMDocument('1.0', 'UTF-8');
            $width = $params->get('width') ?? 560;
            $height = $params->get('height') ?? 315;

            $allow = '"' . 
                ($params->get('enable_accelerometer') ? 'accelerometer;' : '') . 
                ($params->get('enable_autoplay') ? 'autoplay;' : '') . 
                ($params->get('enable_encrypted') ? 'encrypted-media;' : '') . 
                ($params->get('enable_gyroscope') ? 'gyroscope;' : '') . 
                ($params->get('enable_pip') ? 'picture-in-picture;' : '') . '"';

            $div = $doc->createElement('div');
            $div->setAttribute('class', 'mediatext-videowrapper-' . $this->moduleID);
            $div->setAttribute('style', 'padding-top:' . ($height / $width * 100) . '%;');
            
            $iframe = $doc->createElement('iframe');
            $iframe->setAttribute('class', 'mediatext-video-' . $this->moduleID);
            $iframe->setAttribute('src', $params->get('video'));
            $iframe->setAttribute('allowfullscreen', $params->get("enable_fullscreen"));
            $iframe->setAttribute('allow', $allow);
            $iframe->setAttribute('width', $width);
            $iframe->setAttribute('height', $height);
            $iframe->setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
            $iframe->setAttribute('frameborder', '0');
            $iframe->setAttribute('scrolling', 'no');
            $iframe->setAttribute('style', 'border:none;overflow:hidden');
            $iframe->setAttribute('loading', $params->get('enable_lazyloading') ? 'lazy' : 'eager');

            $div->appendChild($iframe);
            $doc->appendChild($div);

            return $doc->saveHTML();
        }

        public function buildOutput(&$p, $media_type) {
            $htmlstring="";

            if($media_type == "custom_video" || $media_type == "fb_video" || $media_type == "yt_video") {
                $htmlstring = $this->buildEmbeddedVideoContainer($p);
            } elseif ($media_type == "image") {
                $htmlstring = $this->buildImageContainer($p);

            } else {
                $htmlstring = "Error finding media to display.";
            }

            return $htmlstring;
        }
    }

?>