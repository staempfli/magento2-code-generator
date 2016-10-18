<?php
/**
 * Gallery
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Block;

class ${Slidername} extends Template
{
    /**
     * @var string $_template
     */
    protected $_template = "${slidername}.phtml";

    /**
     * {@inheritdoc}
     */
    protected function getImages()
    {
        // Here your code
    }

    /**
     * {@inheritdoc}
     */
    protected function getImageThumbnailUrl($image)
    {
        $width = $this->getVar('gallery/thumbwidth');
        $height = $this->getVar('gallery/thumbheight');

        // Your code to return the image url
        // return $this->getImageResizerHelper()->resizeAndGetUrl(image->getSrc(), $width, $height);
    }

    /**
     * {@inheritdoc}
     */
    protected function getImageMediumUrl($image)
    {
        $width = $this->getVar('gallery/width');
        $height = $this->getVar('gallery/height');

        // Your code to return the image url
        // return $this->getImageResizerHelper()->resizeAndGetUrl(image->getSrc(), $width, $height);
    }

    /**
     * {@inheritdoc}
     */
    protected function getImageLargeUrl($image)
    {
        $width = $this->getVar('images/${modulename}_image_full/width');
        $height = $this->getVar('images/${modulename}_image_full/height');

        // Your code to return the image url
        // return $this->getImageResizerHelper()->resizeAndGetUrl(image->getSrc(), $width, $height);
    }

    /**
     * {@inheritdoc}
     */
    protected function isMainImage($image)
    {
        // Here your code
    }
}
