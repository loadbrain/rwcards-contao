<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Ralf Weber
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  LoadBrain 2011
 * @author     Ralf Weber <http://www.loadbrain.de>
 * @package    Calendar
 * @license    LGPL
 * @filesource
 */
class MyClass extends Frontend {

	public function myGenerateFrontendUrl($arrRow, $strParams, $strUrl){

		return ($strUrl);
		//return str_replace('.html', '', $strUrl);
	}

	public function deleteOldCards(){
		$lifetimeDate = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-$_SESSION['rwcards']['config']['rwcards_keep_cards'], date("Y")));

		$res = $this->Database->prepare("select writtenOn FROM tl_rwcardsdata")->execute();
		$rows = $res->fetchAllAssoc();

		for ($i=0; $i<count($rows); $i++)
		{
			if ($rows[$i]['writtenOn'] <= $lifetimeDate)
			{
				$this->log('DELETE FROM tl_rwcardsdata WHERE writtenOn <= ' . $lifetimeDate . '', 'CronJobsRWCards: deleteOldCards()', TL_CRON);
				$this->Database->prepare("DELETE FROM tl_rwcardsdata WHERE writtenOn <= '" . $lifetimeDate . "'")->execute();
			}
		}
	}

	public function myGetImage($image, $width, $height, $mode, $strCacheName, $objFile){//print_r($objFile);
		if (!strlen($image))
		{
			return null;
		}

		$image = urldecode($image);

		// Check whether the file exists
		if (!file_exists(TL_ROOT . '/' . $image))
		{
			$this->log('Image "' . $image . '" could not be found', 'Controller getImage()', TL_ERROR);
			return null;
		}

		$objFile = new File($image);
		$arrAllowedTypes = trimsplit(',', strtolower($GLOBALS['TL_CONFIG']['validImageTypes']));

		// Check the file type
		if (!in_array($objFile->extension, $arrAllowedTypes))
		{
			$this->log('Image type "' . $objFile->extension . '" was not allowed to be processed', 'Controller getImage()', TL_ERROR);
			return null;
		}

		// No resizing required
		if ($objFile->width == $width && $objFile->height == $height)
		{
			return $image;
		}
			// Return the path to the original image if the GDlib cannot handle it
		if (!extension_loaded('gd') || !$objFile->isGdImage || $objFile->width > 3000 || $objFile->height > 3000 || (!$width && !$height) || $width > 1200 || $height > 1200)
		{
			return $image;
		}

		$intPositionX = 0;
		$intPositionY = 0;
		$intWidth = $width;
		$intHeight = $height;

		// Mode-specific changes
		if ($intWidth && $intHeight)
		{
			switch ($mode)
			{
				case 'proportional':
					if ($objFile->width >= $objFile->height)
					{
						unset($height, $intHeight);
					}
					else
					{
						unset($width, $intWidth);
					}
					break;

				case 'box':

					if (ceil($objFile->height * $width / $objFile->width) <= $intHeight)
					{
						unset($height, $intHeight);
					}
					else
					{
						unset($width, $intWidth);
					}
					break;
			}
		}

		// Resize width and height and crop the image if necessary
		if ($intWidth && $intHeight)
		{
			if (($intWidth * $objFile->height) != ($intHeight * $objFile->width))
			{
				$intWidth = ceil($objFile->width * $height / $objFile->height);
				$intPositionX = -intval(($intWidth - $width) / 2);

				if ($intWidth < $width)
				{
					$intWidth = $width;
					$intHeight = ceil($objFile->height * $width / $objFile->width);
					$intPositionX = 0;
					$intPositionY = -intval(($intHeight - $height) / 2);
				}
			}

			$strNewImage = imagecreatetruecolor($width, $height);
		}

		// Calculate the height if only the width is given
		elseif ($intWidth)
		{
			$intHeight = ceil($objFile->height * $width / $objFile->width);
			$strNewImage = imagecreatetruecolor($intWidth, $intHeight);
		}

		// Calculate the width if only the height is given
		elseif ($intHeight)
		{
			$intWidth = ceil($objFile->width * $height / $objFile->height);
			$strNewImage = imagecreatetruecolor($intWidth, $intHeight);
		}

		$arrGdinfo = gd_info();
		$strGdVersion = preg_replace('/[^0-9\.]+/', '', $arrGdinfo['GD Version']);

		switch ($objFile->extension)
		{
			case 'gif':
				if ($arrGdinfo['GIF Read Support'])
				{
					$strSourceImage = imagecreatefromgif(TL_ROOT . '/' . $image);
					$intTranspIndex = imagecolortransparent($strSourceImage);

					// Handle transparency
					if ($intTranspIndex >= 0 && $intTranspIndex < imagecolorstotal($strSourceImage))
					{
						$arrColor = imagecolorsforindex($strSourceImage, $intTranspIndex);
						$intTranspIndex = imagecolorallocate($strNewImage, $arrColor['red'], $arrColor['green'], $arrColor['blue']);
						imagefill($strNewImage, 0, 0, $intTranspIndex);
						imagecolortransparent($strNewImage, $intTranspIndex);
					}
				}
				break;

			case 'jpg':
			case 'jpeg':
				if ($arrGdinfo['JPG Support'] || $arrGdinfo['JPEG Support'])
				{
					$strSourceImage = imagecreatefromjpeg(TL_ROOT . '/' . $image);
				}
				break;

			case 'png':
				if ($arrGdinfo['PNG Support'])
				{
					$strSourceImage = imagecreatefrompng(TL_ROOT . '/' . $image);

					// Handle transparency (GDlib >= 2.0 required)
					if (version_compare($strGdVersion, '2.0', '>='))
					{
						imagealphablending($strNewImage, false);
						$intTranspIndex = imagecolorallocatealpha($strNewImage, 0, 0, 0, 127);
						imagefill($strNewImage, 0, 0, $intTranspIndex);
						imagesavealpha($strNewImage, true);
					}
				}
				break;
		}

		// The new image could not be created
		if (!$strSourceImage)
		{
			$this->log('Image "' . $image . '" could not be processed', 'Controller getImage()', TL_ERROR);
			return null;
		}

		imagecopyresampled($strNewImage, $strSourceImage, $intPositionX, $intPositionY, 0, 0, $intWidth, $intHeight, $objFile->width, $objFile->height);

		// Fallback to PNG if GIF ist not supported
		if ($objFile->extension == 'gif' && !$arrGdinfo['GIF Create Support'])
		{
			$objFile->extension = 'png';
		}

		// Create the new image
		switch ($objFile->extension)
		{
			case 'gif':
				imagegif($strNewImage, TL_ROOT . '/' . $strCacheName);
				break;

			case 'jpg':
			case 'jpeg':
				imagejpeg($strNewImage, TL_ROOT . '/' . $strCacheName, (!$GLOBALS['TL_CONFIG']['jpgQuality'] ? 80 : $GLOBALS['TL_CONFIG']['jpgQuality']));
				break;

			case 'png':
				imagepng($strNewImage, TL_ROOT . '/' . $strCacheName);
				break;
		}

		// Destroy the temporary images
		imagedestroy($strSourceImage);
		imagedestroy($strNewImage);

		// Set the file permissions when the Safe Mode Hack is used
		if ($GLOBALS['TL_CONFIG']['useFTP'])
		{
			$this->import('Files');
			$this->Files->chmod($strCacheName, 0644);
		}

		// Return the path to new image
		//return $strCacheName;
		return $strCacheName;
	}
}
?>