<?php if (!defined('APPLICATION')) die();


//
// Here's the info about my meager plugin
//
$PluginInfo['mmwebfonts'] = array
(
  'Name' => 'MMWebFonts',
  'Description' => 'Myanmar Unicode font embed',
  'Version' => '1.0.4',
  'Author' => 'saturngod',
  'AuthorEmail' => 'saturngod@gmail.com',
  'AuthorUrl' => 'http://en.saturngod.net',
  'SettingsUrl' => '/dashboard/settings/mmwebfonts',
  'SettingsPermission' => 'Garden.Moderation.Manage',
  'MobileFriendly' => TRUE,
  'RequiredTheme' => FALSE, 
  'RequiredPlugins' => FALSE
);

//
// Did I mention this was a plugin?  That would explain our desire to
// extend Gdn_Plugin. How else would we be an uber-plugin of hawtness?
//
class mmwebfontsPlugin extends Gdn_Plugin
{
  public function Base_Render_Before(&$Sender)
  {
   
    $fontfamily = 'Myanmar3';
    $font = C('Plugins.mmwebfonts.SelectedFont', 'mon3');
    if($font == 'mon3')
    {
      $fontfamily = 'MON3 Anonta 1';
    }
    
    $link = "<link href='http://mmwebfonts.comquas.com/fonts/?font=".$font."' rel='stylesheet' type='text/css'/><style>body,textarea,input,html,h1,h2,h3,h4,h5,h6li,ul,ol,p,div,span,* {font-family:'".$fontfamily."'}</style>";    
    $Sender->Head->AddString($link);
  }

  public function Setup()
  {
    // Nothing to do here!
  }
  
  /**
    * Add the Dashboard menu item.
    */
  public function Base_GetAppSettingsMenuItems_Handler($Sender) {
      $Menu = &$Sender->EventArguments['SideMenu'];
      $Menu->AddLink('Site Settings', T('MMWebFonts'), 'settings/mmwebfonts', 'Garden.Settings.Manage');
   }

  /**
   * Setting Page
   */
  public function SettingsController_mmwebfonts_Create($Sender) {

      $Conf = new ConfigurationModule($Sender);
      $Conf->Initialize(array(
         'Plugins.mmwebfonts.SelectedFont' => array('Control' => 'dropdown', 'Items'=>array('mon3' => 'MON3 Anonta 1','myanmar3'=>'Myanmar 3')),
      ));

      $Sender->AddSideMenu('settings/mmwebfonts');
      $Sender->SetData('Title', T('MMWebFonts'));
      $Sender->ConfigurationModule = $Conf;
      $Conf->RenderAll();
   }

}
