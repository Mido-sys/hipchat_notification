<?php
// use $configuration_group_id where needed

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int)$configuration_group_id . ", 1, 'HIPCHAT_ERROR_ENABLE', 'Enabel Module', 'false', 'Should this module be used', 'zen_cfg_select_option(array(\'true\', \'false\'),');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description) VALUES (" . (int)$configuration_group_id . ", 2, 'HIPCHAT_TOKEN', 'HipChat API Auth Token', '', 'This is the token that you will need to get form hipchat');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int)$configuration_group_id . ", 6, 'HIPCHAT_MESSAGE_FORMAT', 'Message Format', 'text', 'This is the format of message that should be sent, either TEXT or HTML', 'zen_cfg_select_option(array(\'text\', \'html\'),');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description) VALUES (" . (int)$configuration_group_id . ", 4, 'HIPCHAT_NOTIFY_ROOM', 'Notify the room?', '1', 'Should it notify the room, when it sends the message (true = 1)');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description) VALUES (" . (int)$configuration_group_id . ", 9, 'HIPCHAT_MESSAGE_COLOR', 'Color of the message', 'red', 'Background color for message. One of yellow, red, green, purple, gray, or random.');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description) VALUES (" . (int)$configuration_group_id . ", 2, 'HIPCHAT_ROOM_ID', 'Room ID to post the message to', '', 'This is either the name of the room, but more dependable is to use the room id (it also called API ID)');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description) VALUES (" . (int)$configuration_group_id . ", 3, 'HIPCHAT_ERROR_FROM', 'From name on Error messages', 'Error Log', 'This the name that it will appear the message came from');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description) VALUES (" . (int)$configuration_group_id . ", 7, 'HIPCHAT_MAX_LENGTH', 'Maximum length of message', '1000', 'This is the maximum length of the message, HipChat max is 10,000 but that is really long.');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description) VALUES (" . (int)$configuration_group_id . ", 8, 'HIPCHAT_ERROR_PREFIX', 'Prefix on Error Message', '', 'This will be added the the start of the message, this is useful for when you want to notify a person, like @user');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description) VALUES (" . (int)$configuration_group_id . ", 9, 'HIPCHAT_LAST_MESSAGE', 'Last Time Message Sent', '', 'This is the last timestamp a message was sent, set this to zero to send one on the next pageload reguardless');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description) VALUES (" . (int)$configuration_group_id . ", 5, 'HIPCHAT_LIMIT_MESSAGE', 'Limit of Message', '300', 'Change how often messages are sent, setting this at 300 will limit the number of messages to no sooner then every 5 minutes');");
$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_group_id, sort_order, configuration_key, configuration_title, configuration_value, configuration_description, set_function) VALUES (" . (int)$configuration_group_id . ", 3, 'HIPCHAT_API_FORMAT', 'Format to send Notify', 'json', 'Desired response format: json or xml. (default: json)', 'zen_cfg_select_option(array(\'json\', \'xml\'),');");

// For Admin Pages

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) { // continue Zen Cart 1.5.0
  // delete configuration menu
  $db->Execute("DELETE FROM ".TABLE_ADMIN_PAGES." WHERE page_key = 'configHipchat' LIMIT 1;");
  // add configuration menu
  if (!zen_page_key_exists('configHipchat')) {
    if ((int)$configuration_group_id > 0) {
      zen_register_admin_page('configHipchat',
                              'BOX_HIPCHAT_NOTIFICATION', 
                              'FILENAME_CONFIGURATION',
                              'gID=' . $configuration_group_id, 
                              'configuration', 
                              'Y',
                              $configuration_group_id);
        
      $messageStack->add('Enabled HipChat Notification Configuration Menu.', 'success');
    }
  }
}
