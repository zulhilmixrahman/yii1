<?php
class Navigation extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return DNavigation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'navigation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nav_label, nav_module, nav_controller, nav_action, nav_resource, nav_privilage, nav_params', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nav_id, nav_label, nav_module, nav_controller, nav_action, nav_resource, nav_privilage, nav_params', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'nav_id' => 'Nag',
            'nav_label' => 'Nav Label',
            'nav_module' => 'Nav Module',
            'nav_controller' => 'Nav Controller',
            'nav_action' => 'Nav Action',
            'nav_resource' => 'Nav Resource',
            'nav_privilage' => 'Nav Privilage',
            'nav_params' => 'Nav Params',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('nav_id', $this->nav_id);
        $criteria->compare('nav_label', $this->nav_label, true);
        $criteria->compare('nav_module', $this->nav_module, true);
        $criteria->compare('nav_controller', $this->nav_controller, true);
        $criteria->compare('nav_action', $this->nav_action, true);
        $criteria->compare('nav_resource', $this->nav_resource, true);
        $criteria->compare('nav_privilage', $this->nav_privilage, true);
        $criteria->compare('nav_params', $this->nav_params, true);
        $criteria->compare('nav_menu', $this->nav_menu, true);
        $criteria->compare('nav_submenu', $this->nav_submenu, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getItemByPk($pk, $item) {
        $list = $this->findByPk($pk);
        if ($list)
            return $list->$item;
    }

    /* New menu list with 3 level of hierarchy */

    public function getActiveMenu() {
        $home = Yii::app()->homeUrl;
        //Get Parent Menu
        $parents = $this->model()->findAll(array(
            'order' => 'nav_susunan',
            'condition' => 'nav_menu = :id',
            'params' => array(':id' => 1)
        ));

        $item_parent = array();
        foreach ($parents as $parent):
            //Get Item for Parent Menu
            $childs = $this->model()->findAll(array(
                'order' => 'nav_susunan',
                'condition' => 'nav_submenu = :id and nav_menu = :menu',
                'params' => array(
                    ':menu' => 2,
                    ':id' => $parent->nav_id,
            )));

            $item_child = array();
            foreach ($childs as $child):
                $grandChilds = $this->model()->findAll(array(
                    'order' => 'nav_susunan',
                    'condition' => 'nav_submenu = :id and nav_menu = :menu',
                    'params' => array(
                        ':menu' => 3,
                        ':id' => $child->nav_id,
                )));

                if (count($grandChilds) > 0) {
                    //Get if have grand child menu
                    $item_grandChild = array();
                    foreach ($grandChilds as $grandChild):
                        //Set item for grand child menu
                        $item_grandChild[] = array(
                            'label' => '<span class="submenu_child">&raquo; ' . $grandChild->nav_label . '</span>',
                            'url' => $home . '/' . $grandChild->nav_module . '/' . $grandChild->nav_controller . '/' . $grandChild->nav_action,
                            'linkOptions' => array('title' => $grandChild->nav_label),
                            'visible' => true//$this->checkAccess($grandChild->nav_access)
                        );
                    endforeach;

                    //Set item for group of grand child menu
                    $item_child[] = array(
                        'label' => $child->nav_label,
                        'url' => $child->nav_module,
                        'itemOptions' => array(
                        ),
                        'linkOptions' => array(
                            'class' => 'menu_child',
                            'title' => $child->nav_label,
                            'onclick' => 'showMenu(' . $child->nav_id . ', ' . $parent->nav_id . ');'
                        ),
                        'submenuOptions' => array(
                            'class' => 'submenu_child',
                            'style' => 'display:none',
                            'id' => 'subPart_' . $child->nav_id,
                        ),
                        'visible' => true,//$this->checkAccess($child->nav_access),
                        'items' => $item_grandChild,
                    );
                } else {
                    //set as child menu
                    $item_child[] = array(
                        'label' => '<span class="submenu">&raquo; ' . $child->nav_label . '</span>',
                        'url' => $home . '/' . $child->nav_module . '/' . $child->nav_controller . '/' . $child->nav_action,
                        'linkOptions' => array('title' => $child->nav_label),
                        'visible' => true//$this->checkAccess($child->nav_access)
                    );
                }
            endforeach;

            //Set as item for menu
            $item_parent[] = array(
                'label' => $parent->nav_label,
                'url' => $parent->nav_module,
                'itemOptions' => array(
                ),
                'linkOptions' => array(
                    'class' => 'menu',
                    'title' => $parent->nav_label,
                    'onclick' => 'showMenu(' . $parent->nav_id . ', 0);'
                ),
                'submenuOptions' => array(
                    'class' => 'submenu',
                    'style' => 'display:none',
                    'id' => 'subPart_' . $parent->nav_id,
                ),
                'visible' => true,//$this->checkAccess($parent->nav_access),
                'items' => $item_child,
            );
        endforeach;
        return $item_parent;
    }

    /* Old menu with 2 level of hierarchy */

    public function getMenuList() {
        $items = array();
        $results = $this->model()->findAll(array(
            'order' => 'nav_susunan',
            'condition' => 'nav_menu = :id',
            'params' => array(':id' => 1)
        ));
        $counter = 0;
        foreach ($results as $result):
            $sub = $this->getSubMenuList($result->nav_id);

            $items[] = array(
                'label' => $result->nav_label,
                'url' => $result->nav_module,
                'itemOptions' => array(
                ),
                'linkOptions' => array(
                    'class' => 'menu',
                    'title' => $result->nav_label,
                    'onclick' => 'showMenu(' . $counter . ');'
                ),
                'submenuOptions' => array(
                    'class' => 'submenu',
                    'style' => 'display:none',
                    'id' => 'subPart_' . $counter,
                ),
                'visible' => $this->checkAccess($result->nav_access),
                'items' => $sub,
            );
            $counter++;
        endforeach;

        return $items;
    }

    public function getSubMenuList($id) {
        $items = array();
        $home = Yii::app()->homeUrl;
        $results = $this->model()->findAll(
                array(
                    'order' => 'nav_susunan',
                    'condition' => 'nav_submenu = :id AND nav_menu = :menu',
                    'params' => array(
                        ':menu' => 2,
                        ':id' => $id,
                    )
                )
        );

        foreach ($results as $result):

            $items[] = array(
                'label' => $result->nav_label,
                'url' => $home . '/' . $result->nav_module . '/' . $result->nav_controller . '/' . $result->nav_action,
                'linkOptions' => array('title' => $result->nav_label),
                'visible' => $this->checkAccess($result->nav_access)
            );
        endforeach;

        return $items;
    }

    public function checkAccess($access = null) {
        if (($access) && (!Yii::app()->user->isGuest)) {
            foreach (Yii::app()->user->getState('akauRole') as $role):
                if ((strpos($access, $role) !== false) || ($access == '*')) {
                    $counter = 1;
                    break;
                }
            endforeach;
            if ($counter == 1)
                return true;
        }
        return false;
    }

    public function optionsParentMenuList() {
        $list = $this->model()->findAll(array(
            'select' => 'DISTINCT(nav_submenu) AS nav_id'
        ));
        $listArray = "";
        $loop = 0;
        foreach ($list as $lists):
            $loop++;
            $listArray .= $lists->nav_id;
            if ($loop < count($list) && !empty($lists->nav_id))
                $listArray .= ",";
        endforeach;
        $data = $this->model()->findAll(array(
            'condition' => 'nav_id IN (' . $listArray . ')',
            'order' => 'nav_susunan ASC'
        ));
        $array = CHtml::listData($data, 'nav_id', 'nav_label');
        return $array;
    }

}

