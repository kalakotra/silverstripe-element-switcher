<?php

namespace Kalakotra\SilverstripeElementSwitcher\Extensions;

use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;

class ElementalElementSwitcherExtension extends Extension {

    public function updateCMSActions(FieldList $actions): void {
        $rootTabSet = TabSet::create('SwitchActionMenus');
        $dropUpContainer = Tab::create(
            'SwitchMoreOptions',
            _t(__CLASS__ . '.SwitchMoreOptions', 'Switch Element', 'Expands a view for more buttons')
        );
        //$dropUpContainer->addExtraClass('popover-actions-simulate');
        $rootTabSet->push($dropUpContainer);
        $rootTabSet->addExtraClass('ss-ui-action-tabset action-menus btn-element-switcher btn-outline-primary');

        // get all siblings and create edit links
        $mySiblings = $this->getOwner()->Parent()->Elements()->exclude([
            'ID' => $this->getOwner()->ID
        ]);
        $myLinks = '';
        foreach ($mySiblings as $sibling) {
            // create a link to edit the sibling
            $myLinkTitle = $sibling->Title;
            if ($sibling->Title == "") {
                $myLinkTitle = _t(__CLASS__ . '.NoTitle', 'No title') . ' ' . $sibling->ID;
            }

            $myLinks .= '<a href="' . $sibling->CMSEditLink() . '" class="btn">' . $myLinkTitle . '</a><br>';
        }

        $myAction = LiteralField::create(
            'doCustomAction',
            '<div class="cms-sitetree-information">' ._t(__CLASS__ . '.PopupInfo', 'Switch to Element:'). '</div>'.
            $myLinks
        );

        $dropUpContainer->push($myAction);


        $actions->push($rootTabSet);
    }

}
