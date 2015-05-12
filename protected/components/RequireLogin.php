<?php

class RequireLogin extends CBehavior {

    public function attach($owner) {
        $owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
    }

    public function handleBeginRequest($event) {
        $requestUrl = strtolower(trim(Yii::app()->getRequest()->requestUri, '/'));
        $homeUrl = strtolower(trim(Yii::app()->baseUrl, '/'));

        if (Yii::app()->user->isGuest && !($requestUrl == $homeUrl)) {
            Yii::app()->user->loginRequired();
        }
    }

}
