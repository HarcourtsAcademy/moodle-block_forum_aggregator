
<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/*
 * Forum Aggregator
 * 29.11.2011 by T6nis
 * Allows teacher to choose between different forums to show in block.
 * Can add custom title and select how many latest posts to be shown.
 */

class block_forum_aggregator_edit_form extends block_edit_form {
    
    protected function specific_definition($mform) {
        
        //block settings title
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        
        
        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_forum_aggregator'));

        $forums = $this->get_course_forums();
        
        if (!empty($forums)) {
            
            foreach ($forums as $key => $value) {

                //forum title
                $mform->addElement('header', 'forum_settings', $value->name);
                
                $mform->addElement('advcheckbox', 'config_forum_id['.$value->id.']',  get_string('forum_selection', 'block_forum_aggregator'), '', array('group' => 1), array(0,1));
                $mform->addHelpButton('config_forum_id['.$value->id.']', 'forum_selection', 'block_forum_aggregator');
                
                $forum_description_html = '<div class="fitem"><div class="fitemtitle">Forum desription</div><div class="felement fitemdescription">'.$value->intro.'</div></div>';

                $mform->addElement('html', $forum_description_html);
                
                $post_array = array();
                
                //from 0 to 25
                for ($i = 0; $i <= 25; $i++) {
                    $post_array[] = $i; 
                }
                
                $mform->addElement('select', 'config_max_posts['.$value->id.']',  get_string('posts', 'block_forum_aggregator'), $post_array);
                
                $mform->addHelpButton('config_max_posts['.$value->id.']', 'max_num_of_posts', 'block_forum_aggregator');
                
            }
            
        }   
        
    }
    
    //get course forums
    private function get_course_forums() {
        
        global $DB, $CFG, $COURSE, $USER;

        if ($forums = $DB->get_records_select("forum", "course = '$COURSE->id'")) {
            return $forums;
        }

    }
    
    //get selected forum data by id
    private function get_forum_by_id($forumid) {

        global $DB, $CFG, $COURSE, $USER;

        if ($forum = $DB->get_records_select("forum", "course = '$COURSE->id' AND id = '$forumid'")) {
            return $forum;
        }
    }
    
}

?>
