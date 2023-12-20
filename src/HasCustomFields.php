<?php 

namespace GuillermoRod\CustomFields;

use GuillermoRod\CustomFields\CustomField;
use Illuminate\Support\Arr;

trait HasCustomFields
{
    /**
     * Get custom_fields
     *
     * @return MorphMany
     */
    public function custom_fields()
    {
        return $this->morphMany(CustomField::class, 'model');
    }

    /**
     * Attach custom field.
     *
     * @return Builder|Model
     */
    public function attachCustomField(string $name, string $value, ?string $type = null)
    {
        $field = [
            'name'       => $name,
            'value'      => $value,
            'type'       => $type,
            'model_id'   => $this->getKey(),
            'model_type' => get_class($this),
        ];

        return CustomField::query()->create($field);
    }

    /**
     * Attach multiple custom fields.
     *
     * @return bool
     */
    public function attachCustomFields(array $fields)
    {
        $fields = collect($fields)->map(function ($field) {
            $field['model_id']   = $this->getKey();
            $field['model_type'] = get_class($this);
            $field['created_at'] = now();
            $field['updated_at'] = now();
            return $field;
        })->toArray();

        return CustomField::query()->insert($fields);
    }

    /**
     * Check field have special name.
     *
     * @return bool
     */
    public function hasCustomField(string $name)
    {
        return $this->getCustomFieldWhere()
            ->where('name', $name)
            ->exists();
    }

    /**
     * Delete all custom fields.
     * 
     * @return void
     */
    public function deleteAllCustomFields()
    {
        $this->getCustomFieldWhere()->delete();
    }

    /**
     * Delete special attribute.
     *
     * @return int
     */
    public function deleteCustomField(string $name, string $value)
    {
        return $this->getCustomFieldWhere()
            ->where('name', $name)
            ->where('value', $value)
            ->delete();
    }

    /**
     * Pluck custom fields as [name => value]
     *
     * @return array
     */
    public function pluckCustomFields()
    {
        return $this->custom_fields->mapWithKeys(fn ($attr) => [$attr->name => $attr->value])->toArray();
    }

    /**
     * Get attribute with this (model).
     */
    private function getCustomFieldWhere(): MorphMany
    {
        return $this->custom_fields()
            ->where('model_id', $this->getKey())
            ->where('model_type', get_class($this));
    }
}