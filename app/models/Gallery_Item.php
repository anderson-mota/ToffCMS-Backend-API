<?php

/**
 * Class Gallery_Item
 *
 * @property integer $id
 * @property string $type
 * @property string $content
 * @property integer $gallery_id
 * @property integer $order_id
 * @property-read \Gallery $gallery
 */
class Gallery_Item extends Eloquent {

	protected $table = 'gallery_items';
	protected $hidden = array('created_at', 'updated_at', 'gallery_id');

	public function gallery()
	{
		return $this->belongsTo('Gallery');
	}

	public function getIdAttribute($value)
	{
		return (int) $value;
	}

	public function getGalleryIdAttribute($value)
	{
		return (int) $value;
	}

	/**
	 * Delete an image - both from DB and cache
	 *
	 * @param  integer $id
	 *
	 * @return int
	 */
	public static function destroy($id)
	{
		$item = self::find($id);

		if ($item->exists())
		{
			// In case this is an image - delete cache
			if ($item->type === 'image')
			{
				// Delete the main image
				File::delete(Config::get('assets.images.paths.input') . $item->content);

				// Delete resized images
				foreach (Config::get('assets.images.sizes') as $size => $data)
				{
					File::delete(Config::get('assets.images.paths.output') . $size . '_' . $item->content);
				}
			}
		}

		return parent::destroy($id);
	}

	/**
	 * Update the item order
	 * @param  array  $items
	 * @return boolean
	 */
	public static function updateOrder(array $items)
	{
		$index = 0;

		foreach ($items as $row)
		{
			Gallery_Item::where('id', '=', $row['id'])
			            ->update(array('order_id' => ++$index));
		}

		return true;
	}

}
