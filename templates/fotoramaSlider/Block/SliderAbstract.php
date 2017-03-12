<?php
/**
 * SliderAbstract
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Block;

use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

abstract class SliderAbstract extends Template
{
    /**
     * @var EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @param EncoderInterface $jsonEncoder
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        EncoderInterface $jsonEncoder,
        Context $context,
        array $data = []
    ) {
        $this->jsonEncoder = $jsonEncoder;
        parent::__construct($context, $data);
    }

    /**
     * Return magnifier options
     *
     * @return string Json
     */
    public function getMagnifierJson()
    {
        return $this->jsonEncoder->encode($this->getVar('magnifier'));
    }

    /**
     * Return breakpoints options
     *
     * @return string Json
     */
    public function getBreakpointsJson()
    {
        return $this->jsonEncoder->encode($this->getVar('breakpoints'));
    }

    /**
     * Remove options with value set to false
     *
     * @param $options
     * @return array $options
     */
    protected function getProcessedOptions(array $options)
    {
        foreach ($options as $key => $value) {
            if (!$value || $value == 'false') {
                unset($options[$key]);
            }
        }
        return $options;
    }

    /**
     * Return gallery options
     *
     * @return string Json
     */
    public function getGalleryOptionsJson()
    {
        $options = $this->getProcessedOptions($this->getVar('gallery'));
        return $this->jsonEncoder->encode($options);
    }

    /**
     * Return Full screen options
     *
     * @return string Json
     */
    public function getFullScreenJson()
    {
        $options = $this->getProcessedOptions($this->getVar('fullscreen'));
        return $this->jsonEncoder->encode($options);
    }

    /**
     * Retrieve gallery images in JSON format
     *
     * @return string Json
     */
    public function getGalleryImagesJson()
    {
        $images = $this->getImages();
        $imagesItems = [];
        foreach ($images as $image) {
            $imagesItems[] = [
                'thumb' => $this->getImageThumbnailUrl($image),
                'img' => $this->getImageMediumUrl($image),
                'full' => $this->getImageLargeUrl($image),
                //'caption' => $image->getLabel(),
                'position' => $image->getPosition(),
                'isMain' => $this->isMainImage($image),
            ];
        }

        return $this->jsonEncoder->encode($imagesItems);
    }

    /**
     * Get images collection for slider
     */
    abstract protected function getImages();

    /**
     * Get Image thumbnail url
     *
     * @param $image
     * @return mixed
     */
    abstract protected function getImageThumbnailUrl($image);

    /**
     * Get Image medium url
     *
     * @param $image
     * @return mixed
     */
    abstract protected function getImageMediumUrl($image);

    /**
     * Get Image large url
     *
     * @param $image
     * @return mixed
     */
    abstract protected function getImageLargeUrl($image);

    /**
     * Check whether image is main
     *
     * @param $image
     * @return bool
     */
    abstract protected function isMainImage($image);

}
