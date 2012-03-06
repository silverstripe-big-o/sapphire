<?php
/**
 * Allows to detach an item from an existing has_many or many_many relationship.
 * Similar to {@link GridFieldAction_Delete}, but allows to distinguish between 
 * a "delete" and "detach" action in the UI - and to use both in parallel, if required.
 * Requires the GridField to be populated with a {@link RelationList} rather than a plain {@link DataList}.
 * Often used alongside {@link GridFieldRelationAdd} to add existing records to the relationship.
 * For easier setup, have a look at a sample configuration in {@link GridFieldConfig_RelationEditor}.
 */
class GridFieldRelationDelete implements GridField_ColumnProvider, GridField_ActionProvider {
	
	/**
	 * Add a column 'UnlinkRelation'
	 * 
	 * @param type $gridField
	 * @param array $columns 
	 */
	public function augmentColumns($gridField, &$columns) {
		if(!in_array('Actions', $columns))
			$columns[] = 'Actions';
	}
	
	/**
	 * Return any special attributes that will be used for FormField::createTag()
	 *
	 * @param GridField $gridField
	 * @param DataObject $record
	 * @param string $columnName
	 * @return array
	 */
	public function getColumnAttributes($gridField, $record, $columnName) {
		return array();
	}
	
	/**
	 * Don't add an title
	 * 
	 * @param GridField $gridField
	 * @param string $columnName
	 * @return array
	 */
	public function getColumnMetadata($gridField, $columnName) {
		if($columnName == 'Actions') {
			return array('title' => '');
		}
	}
	
	/**
	 * Which columns are handled by this component
	 * 
	 * @param type $gridField
	 * @return type 
	 */
	public function getColumnsHandled($gridField) {
		return array('Actions');
	}
	
	/**
	 * Which GridField actions are this component handling
	 *
	 * @param GridField $gridField
	 * @return array 
	 */
	public function getActions($gridField) {
		return array('unlinkrelation');
	}
	
	/**
	 *
	 * @param GridField $gridField
	 * @param DataObject $record
	 * @param string $columnName
	 * @return string - the HTML for the column 
	 */
	public function getColumnContent($gridField, $record, $columnName) {
		$field = new GridField_FormAction(
			$gridField, 
			'UnlinkRelation'.$record->ID, 
			_t('GridAction.UnlinkRelation', "Unlink"), 
			"unlinkrelation", 
			array('RecordID' => $record->ID)
		);
		$output = $field->Field();
		return $output;
	}
	
	/**
	 * Handle the actions and apply any changes to the GridField
	 *
	 * @param GridField $gridField
	 * @param string $actionName
	 * @param mixed $arguments
	 * @param array $data - form data
	 * @return void
	 */
	public function handleAction(GridField $gridField, $actionName, $arguments, $data) {
		$id = $arguments['RecordID'];
		$item = $gridField->getList()->byID($id);
		if(!$item) return;
		if($actionName == 'unlinkrelation') {
			$gridField->getList()->remove($item);
		}
	}
}
