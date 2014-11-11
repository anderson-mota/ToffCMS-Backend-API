<?php

/**
 * Class Gallery
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\Gallery_Item[] $items
 */
class Gallery extends \Eloquent {

	protected $table = 'gallery';
	protected $hidden = array('updated_at', 'status');

	/**
	 * Validate the input
	 * @param  array $input
	 * @return Validator
	 */
	public function validate($input)
	{
	    return Validator::make($input, $this->rules());
	}

	/**
	 * Validation rules
	 * @return array
	 */
	public function rules()
	{
		return array(
			'title'        => array('required', 'max:100'),
			'slug'         => array('required', 'max:100', 'unique:gallery,slug,' . $this->id),
		);
	}

	public function items()
	{
		return $this->hasMany('Gallery_Item');
	}

	public function getIdAttribute($value)
	{
		return (int) $value;
	}

	/**
	 * Delete the gallery and images
	 *
	 * @param  integer $id
	 *
	 * @return int
	 */
	public static function destroy($id)
	{
		$gallery = self::find($id);

		if ($gallery->exists())
		{
			$items = Gallery_Item::where('gallery_id', '=', $gallery->id)->get();

			foreach ($items as $item)
			{
				Gallery_Item::destroy($item->id);
			}
		}

		return parent::destroy($id);
	}
}
