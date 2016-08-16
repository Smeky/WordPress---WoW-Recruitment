<?php
/*  
	@since 0.01
*/

class Duality_WoW_Recruit_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array (
			'classname' 	=> 'wow_recruitment_widget',
			'description'	=> 'Widget to display WoW recruitement status for your guild'
		);

        $control_ops = array (
            'width'         => 400
        );

		parent::__construct('wow_recruitment_widget', 'WoW Recruitement Widget', $widget_ops, $control_ops);		
	}

	public function widget($args, $instance) {
		global $wowdr_classes;
		global $wowdr_prios;

		/* Add widget title */
		$title		= apply_filters('widget_title', $instance['title']);
		$title_url	= $instance['title-url'];

		echo $args['before_widget'];

		if($title) {
			if($title_url) {
				echo $args['before_title'];
				echo '<a href="' . $title_url . '">' . $title . '</a>';
				echo $args['after_title'];
			}
			else {
				echo $args['before_title'] . $title . $args['after_title'];
			}
		}

		/* Add main widget content */
		foreach($wowdr_classes as $class_k => $class_v) {
			/* Get list of specs that are open */
			$open_specs = $this->get_open_specs($instance, $class_k);

			/* Skip classes that are entirely closed */
			if(empty($open_specs)) {
				continue;
			}

			echo '<div class="wowdr-class-row">';

			$class_img  = plugins_url('/img', WOWDR_ROOT) . '/ClassIcon_' . $class_v['name_img'] . '.png';

			echo '<img class="wowdr-class-icon" width="46" title="' . $class_v['name'] . '" src="' . $class_img . '">';

			/* Add open specs and their priorities */
			foreach($open_specs as $spec_name) {
				$full_name  = $class_k . '_' . $spec_name;
				$prio_name  = $full_name . '_prio';
				$prio_index = $this->get_priority_index($instance[$prio_name]);
				$prio_img 	= $this->get_priority_image($prio_index);				
				$spec_img   = plugins_url('/img', WOWDR_ROOT) . '/Spec_' . $class_v['name_img'] . '_' . $spec_name . '.png';

				echo '<div class="wowdr-spec-pair">';

				echo '<img class="wowdr-spec-icon wowdr-spec-icon-prio-' . $prio_index . '" 
						   width="32" 
						   title="' . $spec_name . '" 
						   src="' . $spec_img . '">';
			
				echo '<img class="wowdr-spec-prio-icon wowdr-spec-prio-' . $prio_index . '" 
						   title="' . $wowdr_prios[$prio_index] . '" 
						   src="' . $prio_img . '">';

				echo '</div> <!-- /wowdr-spec-pair -->';
			}

			echo '</div> <!-- /wowdr-class-row -->';
		}

		/* Add widget's footer */

		?>

		<div class="wowdr-footer">
			<div class="wowdr-legend">

				<p>
					<img class="wowdr-legend-prio-icon" src="<?php echo $this->get_priority_image(1); ?>"> High
					<img class="wowdr-legend-prio-icon" src="<?php echo $this->get_priority_image(2); ?>"> Medium
					<img class="wowdr-legend-prio-icon" src="<?php echo $this->get_priority_image(3); ?>"> Low
				</p>

			</div> <!-- /wowdr-legend -->
		</div> <!-- /wowdr-footer -->

		<?php

		echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance) {
		global $wowdr_classes;

		$instance = $old_instance;

		$instance['title'] 	   = $new_instance['title'];
		$instance['title-url'] = $new_instance['title-url'];

		foreach($wowdr_classes as $class_k => $class_v) {
			for($i = 1; $i <= $class_v['spec_count']; $i++) {
				$spec_name = $class_v['spec_' . $i . '_name'];
				$full_name = $class_k . '_' . $spec_name;
				$prio_name = $full_name . '_prio';

				$instance[$full_name] = $new_instance[$full_name];
				$instance[$prio_name] = $new_instance[$prio_name];
			}
		}

		return $instance;
	}

	public function form($instance) {
		global $wowdr_classes;
		global $wowdr_prios;

		?>

		<label for="<?php echo $this->get_field_id('title'); ?>">Title (optional)</label>
		<input id="<?php echo $this->get_field_id('title'); ?>"
			   name="<?php echo $this->get_field_name('title'); ?>"
			   value="<?php echo $instance['title']; ?>"
			   style="width: 100%;"
		/>

		<label for="<?php echo $this->get_field_id('title-url'); ?>">URL to your recruitment page</label>
		<input id="<?php echo $this->get_field_id('title-url'); ?>"
			   name="<?php echo $this->get_field_name('title-url'); ?>"
			   value="<?php echo $instance['title-url']; ?>"
			   style="width: 100%;"
		/>

        <table style="width: 100%;">

    		<?php 

            $cell_counter = 0;

    		foreach($wowdr_classes as $class_k => $class_v) {
    			if($cell_counter == 0 || $cell_counter % 2 == 0) {
                    echo '<tr>';
                }

                ?>

                <td style="vertical-align: top;">
        			<p style="padding: 2px 2px 2px 5px; 
                              background: linear-gradient(to right, #d4d4d4 , transparent); 
                              text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5);">

        				<label for="<?php echo $this->get_field_id($class_k); ?>"
        					   style="font-weight: bold; color: <?php echo $class_v['color'] ?>;">
        					   <?php echo $class_v['name']; ?>
        				</label>
        			</p>

        			<ul>

        				<?php

        				for($i = 1; $i <= $class_v['spec_count']; $i++) {
        					$spec_name = $class_v['spec_' . $i . '_name'];
        					$full_name = $class_k . '_' . $spec_name;
        					$prio_name = $full_name . '_prio';
        					$spec_img  = plugins_url('/img', WOWDR_ROOT) . '/Spec_' . $class_v['name_img'] . '_' . $spec_name . '.png';

        					?>

        					<li style="margin-bottom: -5px;">
        						<img title="<?php echo $spec_name; ?>" 
        							 width="32" 
        							 src="<?php echo $spec_img; ?>"
        							 style="margin-right: 5px;"
        						>
        						<input class="checkbox"
        							   type="checkbox"
        							   <?php checked($instance[$full_name], 'on') ?>
        							   id="<?php echo $this->get_field_id($full_name); ?>"
        							   name="<?php echo $this->get_field_name($full_name); ?>"
        						/>
        						<select id="<?php echo $this->get_field_id($prio_name); ?>"
        							    name="<?php echo $this->get_field_name($prio_name); ?>"
        						>

        						<?php 

        						for($j = 1; $j <= 3; $j++) {
        							?>

        							<option value="<?php echo $wowdr_prios[$j]; ?>"
        									<?php selected($instance[$prio_name], $wowdr_prios[$j]); ?>
        							>
        								<?php echo $j . ') ' . $wowdr_prios[$j]; ?>
        							</option>

        							<?php
        						}

        						?>

        						</select>
        					</li>

        					<?php
        				}

        			?>

        			</ul>
                </td>

    			<?php

                $cell_counter++;

                if($cell_counter % 2 == 0 || $cell_counter == count($wowdr_classes)) {
                    echo '</tr>';
                }
            }

        ?>
        </table>
        <?php

		return $instance;
	}

	/*  
		Desc: Returns wherther the class has open at least on spec or not
	*/
	private function get_open_specs($instance, $class_name) {
		global $wowdr_classes;

		$class_data = $wowdr_classes[$class_name];
		$open_specs = array();

		for($i = 1; $i <= $class_data['spec_count']; $i++) {
			$spec_name = $class_data['spec_' . $i . '_name'];
			$full_name = $class_name . '_' . $spec_name;

			if($instance[$full_name] == 'on') {
				array_push($open_specs, $spec_name);
			}
		}

		return $open_specs;
	}

	/*  
		Desc: Returns index of priority based on its name
	*/
	private function get_priority_index($prio) {
		if(strpos($prio, 'Low') !== false) {
			return 3;
		}
		else if(strpos($prio, 'Medium') !== false) {
			return 2;
		}
		else if(strpos($prio, 'High') !== false) {
			return 1;
		}
		else {
			return 0;
		}
	}

	private function get_priority_image($prio_index) {
		if($prio_index == 1) {
			return plugins_url('/img', WOWDR_ROOT) . '/Prio_High.png';
		}
		else if($prio_index == 2) {
			return plugins_url('/img', WOWDR_ROOT) . '/Prio_Medium.png';
		}
		else if($prio_index == 3) {
			return plugins_url('/img', WOWDR_ROOT) . '/Prio_Low.png';
		}
		else {
			return '';
		}
	}

}


?>