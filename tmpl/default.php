<?php 
    // No direct access
    defined('_JEXEC') or die;

    $id = $module->id;
    $media_type = "image";

    if($params->get('dropdown') == 1) {
        $media_type = "custom_video";
        if($params->get('video_type') == 1) {
            $media_type = "fb_video";
        } elseif($params->get('video_type') == 2) {
            $media_type = "yt_video";
        }
    }


    $document = JFactory::getDocument();
    //JHtml::_('jquery.framework');
    $document->addStyleSheet(JUri::base() . 'media/mod_media_text/css/main.css');

    $general_style = "
        .mediatext-wrapper-" . $id . " {
            position: relative;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            height: auto;
            margin-bottom:" . $params->get('bottom_margin') . "px;
        }

        .mediatext-mediawrapper-" . $id . "{
            box-shadow: 0px 0px 10px grey;
            width: 33.33%;
        }

        .mediatext-mediawrapper-" . $id . " img {
            width: 100%;
            height: auto;
            display: block;
        }

        .mediatext-videowrapper-" . $id . " {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .mediatext-video-" . $id . " {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .mediatext-text-" . $id . " {
            padding-left: 20px;
        }

        .mediatext-text-" . $id . " p:last-child {
            margin-bottom: 0px;
        }

        .mediatext-desktop-" . $id . " {
            display: block;
        }

        .mediatext-mobile-" . $id . " {
            display: none;
        }
    ";

    $document->addStyleDeclaration($general_style);
?>

<div class="mediatext-wrapper-<?php echo $id ?> <?php echo $params->get('module_class') ?>">
    <div class="mediatext-mediawrapper-<?php echo $id ?>" style="<?php echo 'width: ' . ($params->get('media_width')) . '%'?>">
        <?php echo $mediatext_outputBuilder->buildOutput($params, $media_type) ?>
    </div>
    <div class="mediatext-text-<?php echo $id ?> <?php echo $params->get('text_class') ?> mediatext-desktop-<?php echo $id ?>" style="<?php echo 'width: ' . (100 - $params->get('media_width')) . '%'?>">
        <?php echo $params->get('text')?>
    </div>
    <?php if($params->get('mobile_text') !== "" and $params->get('toggle-mobile') == 1): ?>
        <div class="mediatext-text-<?php echo $id ?> <?php echo $params->get('text_class') ?> mediatext-mobile-<?php echo $id ?>">
            <?php echo $params->get('mobile_text')?>
        </div>
    <?php endif;?>
</div>

<?php
    if ($params->get('toggle-mobile') == 1) {
        echo "<style type=\"text/css\"> 
            @media (max-width:" . ($params->get('mobile-threshold') . 'px') . ") {
                .mediatext-wrapper-" . $id . " {
                    flex-direction: column;
                }

                .mediatext-mediawrapper-" . $id . "{
                    width: 100% !important;
                }

                .mediatext-text-" . $id . "{
                    width: 100% !important;
                    padding: 20px;
                }" . (($params->get('mobile_text') !== "") ? 

                ".mediatext-mobile-" . $id . "{
                    display: block;
                }

                .mediatext-desktop-" . $id . " {
                    display: none;
                }" : "") . "
            }
            </style>";
    }
?>