<?php 
if ( !defined('ABSPATH')){ exit; }

class ContactOpeningHours extends WP_Widget{
    function ContactOpeningHours() {
        $widget_ops = array( 'classname' => 'kontakt_widget', 'description' => __('Lägg din kontaktinformation här.', 'wktheme') );
        parent::__construct( 'ContactOpeningHours', __('Kontakt &amp; Öppetider', 'wktheme'), $widget_ops );
    }
    
	function widget($args, $instance){
		extract($args, EXTR_SKIP);
		
		$title = empty($instance['title']) ? '' : $args['before_title'].apply_filters('widget_title', $instance['title']).$args['after_title'];
		$city = empty($instance['city']) ? '' : $instance['city'];
		$address = empty($instance['address']) ? '' : $instance['address'];
		$zip = empty($instance['zip']) ? '' : $instance['zip'];
		$state = empty($instance['state']) ? '' : $instance['state'];
		$address_extra = empty($instance['address_extra']) ? '' : apply_filters('address_extra', $instance['address_extra']);
		$phone = empty($instance['phone']) ? '' : $instance['phone'];
		$fax = empty($instance['fax']) ? '' : $instance['fax'];
		$email = empty($instance['email']) ? '' : $instance['email'];
		$monfri = (empty($instance['openinghoursfrommonfri']) || empty($instance['openinghourstomonfri']) ? '' : $instance['openinghoursfrommonfri'].' - '.$instance['openinghourstomonfri']);
		$sat = (empty($instance['openinghoursfromsat']) || empty($instance['openinghourstosat']) ? '' : $instance['openinghoursfromsat'].' - '.$instance['openinghourstosat']);
		$sun = (empty($instance['openinghoursfromsun']) || empty($instance['openinghourstosun']) ? '' : $instance['openinghoursfromsun'].' - '.$instance['openinghourstosun']);
		$free_text = empty($instance['free_text']) ? '' : $instance['free_text'];
		
		// Before widget code, if any
		echo (isset($before_widget) ? $before_widget : '');
		
		echo $title.
			 '<div itemscope itemtype="https://schema.org/Store">
				<div class="storename">
					<p><span itemprop="name">'.get_bloginfo('name').'</span></p>
					<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">'.
						((empty($address)) ? '' : '<p><span itemprop="streetAddress">'.$address.'</span></p>').
						'<p>'.
							((empty($zip)) ? '' : ' <span class="zip" itemprop="postalCode">'.$zip.'</span>').
							((empty($city)) ? '' : ' <span class="city" itemprop="addressLocality">'.$city.'</span>').
							((empty($state)) ? '' : ' <span class="state" itemprop="addressRegion">'.$state.'</span>').
						'</p>'.
						((empty($address_extra)) ? '' : '<p>('.$address_extra.')</p>').
					'</div>
				</div>
				<div class="contactinfo">
					<p>'.__('Kontakt information', 'wktheme').'</p>'.
					((empty($phone)) ? '' : '<p>'.__('Tel', 'wktheme').': <a href="tel:'.antispambot($phone).'"><span class="phone" itemprop="telephone">'.antispambot($phone).'</span></a></p>').
					((empty($fax)) ? '' : '<p>'.__('Fax', 'wktheme').': <span class="fax" itemprop="faxNumber">'.antispambot($fax).'</span></p>').
					((empty($email)) ? '' : '<p>'.__('Email', 'wktheme').': <a href="mailto:'.antispambot($email).'"><span class="email" itemprop="email">'.antispambot($email).'</span></a></p>').	
				'</div>
				 <div class="openinginfo">
					<p>'.__('Öppetider', 'wktheme').'</p>'.
					((empty($monfri)) ? '' : '<p><time itemprop="openingHours" datetime="'.__('Mo-Fr', 'wktheme').' '.$monfri.'">'.__('Måndag-Fredag', 'wktheme').' '.$monfri.'</time></p>').
					((empty($sat)) ? '' : '<p><time itemprop="openingHours" datetime="'.__('Sa', 'wktheme').' '.$sat.'">'.__('Lördag', 'wktheme').' '.$sat.'</time></p>').
					((empty($sun)) ? '' : '<p><time itemprop="openingHours" datetime="'.__('Su', 'wktheme').' '.$sun.'">'.__('Söndag', 'wktheme').' '.$sun.'</time></p>').
					((empty($free_text)) ? '' : '<p>'.$free_text.'</p>').
				'</div>'.
			  '</div>';
		
		// After widget code, if any  
		echo (isset($after_widget) ? $after_widget : '');
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['city'] = strip_tags($new_instance['city']);
		$instance['company'] = strip_tags($new_instance['company']);
		$instance['address'] = strip_tags($new_instance['address']);
		$instance['zip'] = strip_tags($new_instance['zip']);
		$instance['state'] = strip_tags($new_instance['state']);
		$instance['address_extra'] = strip_tags($new_instance['address_extra']);
		$instance['phone'] = strip_tags($new_instance['phone']);
		$instance['fax'] = strip_tags($new_instance['fax']);
		$instance['email'] = strip_tags($new_instance['email']);
		$instance['openinghoursfrommonfri'] = strip_tags($new_instance['openinghoursfrommonfri']); 
		$instance['openinghourstomonfri'] = strip_tags($new_instance['openinghourstomonfri']);
		$instance['openinghoursfromsat'] = strip_tags($new_instance['openinghoursfromsat']); 
		$instance['openinghourstosat'] = strip_tags($new_instance['openinghourstosat']);
		$instance['openinghoursfromsun'] = strip_tags($new_instance['openinghoursfromsun']); 
		$instance['openinghourstosun'] = strip_tags($new_instance['openinghourstosun']);
		$instance['free_text'] = strip_tags($new_instance['free_text']);
		
		return $instance;
	}

	function form($instance){
		$title = esc_attr($instance['title']);
		$city = esc_attr($instance['city']);
		$address = esc_attr($instance['address']);
		$zip = esc_attr($instance['zip']);
		$state = esc_attr($instance['state']);
		$address_extra = esc_attr($instance['address_extra']);
		$phone = esc_attr($instance['phone']);
		$fax = esc_attr($instance['fax']);
		$email = esc_attr($instance['email']);
		$openinghoursfrommonfri = esc_attr($instance['openinghoursfrommonfri']);
		$openinghourstomonfri = esc_attr($instance['openinghourstomonfri']);
		$openinghoursfromsat = esc_attr($instance['openinghoursfromsat']);
		$openinghourstosat = esc_attr($instance['openinghourstosat']);
		$openinghoursfromsun = esc_attr($instance['openinghoursfromsun']);
		$openinghourstosun = esc_attr($instance['openinghourstosun']);
		$free_text = esc_attr($instance['free_text']);
		
		$states = array('Blekinge','Dalarnas','Gotland','Gävleborg','Halland','Jämtland','Jönköping','Kalmar','Kronoberg','Norrbotten','Skåne','Stockholm','Södermanland','Uppsala','Värmland','Västerbotten','Västernorrland','Västmanland','Västra Götaland','Örebro','Östergötland');
		$hours = array('01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00','00:00');
		?>
        <p>
        	<strong><?php echo __('Titel', 'wktheme'); ?>:</strong>
        	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
        </p>
        <p>
			<strong><?php echo __('Välj stad', 'wktheme'); ?>:</strong>
           	<select class="widefat" id="<?php echo $this->get_field_id('infofor'); ?>" name="<?php echo $this->get_field_name('city'); ?>">
            	<option value="" <?php echo ($city == '') ? 'selected="selected"' : ''; ?>><?php echo __('Välj', 'wktheme'); ?></option>
           		<option value="<?php echo __('Stockholm', 'wktheme'); ?>" <?php echo ($city == 'Klässbol') ? 'selected="selected"' : ''; ?>><?php echo __('Stockholm', 'wktheme'); ?></option>
                <option value="<?php echo __('Sandy Point Village', 'wktheme'); ?>" <?php echo ($city == 'Stockholm') ? 'selected="selected"' : ''; ?>><?php echo __('Sandy Point Village', 'wktheme'); ?></option>
            </select>
		</p>
		<p>
			<strong><?php echo __('Adress', 'wktheme'); ?>:</strong>
            <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo $address; ?>" />
		</p>
        <p>
			<strong><?php echo __('Postnummer', 'wktheme'); ?>:</strong>
            <input class="widefat" id="<?php echo $this->get_field_id('zip'); ?>" name="<?php echo $this->get_field_name('zip'); ?>" type="text" value="<?php echo $zip; ?>" />
		</p>
        <p>
        	<strong><?php echo __('Län', 'wktheme'); ?>:</strong>
            <select class="widefat" id="<?php echo $this->get_field_id('state'); ?>" name="<?php echo $this->get_field_name('state'); ?>">
                <option value="" <?php echo ($state == '') ? 'selected="selected"' : ''; ?>><?php echo __('State', 'wktheme'); ?></option>
                <?php 
			   		foreach ($states as $staten){
                		echo '<option value="'.$staten.'" '.(($staten == $state) ? 'selected="selected"' : '').'>'.$staten.'</option>';
					}
				?>
            </select>
		</p>
         <p>
        	<strong><?php echo __('Adress (Extra info)', 'wktheme'); ?>:</strong>
            <input class="widefat" id="<?php echo $this->get_field_id('address_extra'); ?>" name="<?php echo $this->get_field_name('address_extra'); ?>" type="text" value="<?php echo $address_extra; ?>" />
		</p>
        <p>
        	<strong><?php echo __('Telefon', 'wktheme'); ?>:</strong>
            <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo $phone; ?>" />
		</p>
        <p>
        	<strong><?php echo __('Fax', 'wktheme'); ?>:</strong>
            <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" type="text" value="<?php echo $fax; ?>" />
		</p>
        <p>
        	<strong><?php echo __('E-post', 'wktheme'); ?>:</strong>
            <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" />
		</p>
        <p><strong><?php echo __('Öppetider Måndag-Fredag', 'wktheme'); ?>:</strong></p>
        <p>
            <select class="widefat" id="<?php echo $this->get_field_id('openinghoursfrommonfri'); ?>" name="<?php echo $this->get_field_name('openinghoursfrommonfri'); ?>" style="display:inline-block;width:49%;margin-right:1%;">
                <option value="" <?php echo ($openinghoursfrommonfri == '') ? 'selected="selected"' : ''; ?>><?php echo __('Från', 'wktheme'); ?></option>
                <?php 
			   		foreach ($hours as $hour){
                		echo '<option value="'.$hour.'" '.(($hour == $openinghoursfrommonfri) ? 'selected="selected"' : '').'>'.$hour.'</option>';
					}
				?>
            </select>
            <select class="widefat" id="<?php echo $this->get_field_id('openinghourstomonfri'); ?>" name="<?php echo $this->get_field_name('openinghourstomonfri'); ?>" style="display:inline-block;width:49%;">
                <option value="" <?php echo ($openinghourstomonfri == '') ? 'selected="selected"' : ''; ?>><?php echo __('Till', 'wktheme'); ?></option>
                <?php 
			   		foreach ($hours as $hour){
                		echo '<option value="'.$hour.'" '.(($hour == $openinghourstomonfri) ? 'selected="selected"' : '').'>'.$hour.'</option>';
					}
				?>
            </select>
        </p>
        <p><strong><?php echo __('Öppetider Lördag', 'wktheme'); ?>:</strong></p>
        <p>    
            <select class="widefat" id="<?php echo $this->get_field_id('openinghoursfromsat'); ?>" name="<?php echo $this->get_field_name('openinghoursfromsat'); ?>" style="display:inline-block;width:49%;margin-right:1%;">
                <option value="" <?php echo ($openinghoursfromsat == '') ? 'selected="selected"' : ''; ?>><?php echo __('Från', 'wktheme'); ?></option>
                <?php 
			   		foreach ($hours as $hour){
                		echo '<option value="'.$hour.'" '.(($hour == $openinghoursfromsat) ? 'selected="selected"' : '').'>'.$hour.'</option>';
					}
				?>
            </select>
            <select class="widefat" id="<?php echo $this->get_field_id('openinghourstosat'); ?>" name="<?php echo $this->get_field_name('openinghourstosat'); ?>" style="display:inline-block;width:49%;">
                <option value="" <?php echo ($openinghourstosat == '') ? 'selected="selected"' : ''; ?>><?php echo __('Till', 'wktheme'); ?></option>
                <?php 
			   		foreach ($hours as $hour){
                		echo '<option value="'.$hour.'" '.(($hour == $openinghourstosat) ? 'selected="selected"' : '').'>'.$hour.'</option>';
					}
				?>
            </select>
		</p>
        <p><strong><?php echo __('Öppetider Söndag', 'wktheme'); ?>:</strong></p>
        <p>
            <select class="widefat" id="<?php echo $this->get_field_id('openinghoursfromsun'); ?>" name="<?php echo $this->get_field_name('openinghoursfromsun'); ?>" style="display:inline-block;width:49%;margin-right:1%;">
                <option value="" <?php echo ($openinghoursfromsun == '') ? 'selected="selected"' : ''; ?>><?php echo __('Från', 'wktheme'); ?></option>
                <?php 
			   		foreach ($hours as $hour){
                		echo '<option value="'.$hour.'" '.(($hour == $openinghoursfromsun) ? 'selected="selected"' : '').'>'.$hour.'</option>';
					}
				?>
            </select>
            <select class="widefat" id="<?php echo $this->get_field_id('openinghourstosun'); ?>" name="<?php echo $this->get_field_name('openinghourstosun'); ?>" style="display:inline-block;width:49%;">
                <option value="" <?php echo ($openinghourstosun == '') ? 'selected="selected"' : ''; ?>><?php echo __('Till', 'wktheme'); ?></option>
                <?php 
			   		foreach ($hours as $hour){
                		echo '<option value="'.$hour.'" '.(($hour == $openinghourstosun) ? 'selected="selected"' : '').'>'.$hour.'</option>';
					}
				?>
            </select>
        </p>
        <p>
        	<strong><?php echo __('Fri text', 'wktheme'); ?>:</strong>
            <textarea class="widefat" id="<?php echo $this->get_field_id('free_text'); ?>" name="<?php echo $this->get_field_name('free_text'); ?>" value="<?php echo $free_text; ?>" rows="10" style="resize:vertical;"><?php echo $free_text; ?></textarea>
		</p>
		<?php
	}
}

/* 
* Register custom widgets
*/
register_widget('ContactOpeningHours');
