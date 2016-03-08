
        <?php 
		
		  //start by fetching the terms 
			
			
		echo 'This is the right page';	
		echo '<div class="ndi_dance_calendar">';
				
				$count = 0;
				
				
				$locations = get_terms('jwj_location',
					array(
						'orderby'    => 'count',
						'hide_empty' => 0,
						'order' => 'DESC',
						)
					);
				$styles = get_terms('jwj_style',
					array(
						'orderby'    => 'count',
						'hide_empty' => 0,
						'order' => 'DESC',
						)
					);
				
				
					
						echo '<div class="dance_styles_list">';
						
						foreach( $styles as $style ) {
							
							$list_args = array(
								'post_type' => 'jwj_class',	
								'posts_per_page' => -1,
								
								
							);
							$term_link = get_term_link($style, 'jwj_style');
							$list_query = new WP_Query( $list_args );
									
							if ($list_query->have_posts()) {
								echo '<a href="' . $term_link . '">' . $style->name . '</a>';
								
							};
								
							
						};
						
						echo '</div>';
						
					
						
						
				echo '<hr class="clear">';
				
				// now run a query for each location
				foreach( $locations as $location ) {
				 	$count++;
					
					$image = get_field('image', $location);
					// Define the query
					$args = array(
						'post_type' => 'jwj_class',	
						'posts_per_page' => -1,
						'location' => $location->slug,
						'tax_query' => array(
							array (
								'taxonomy' => 'jwj_style',
								'field' => 'ID',
								'terms' => $queried_style_ID,
							),
						
						),
					);
					$query = new WP_Query( $args );
					
					
					
					// output the term name and image        
					
					if ($query->have_posts()) {
						//Define an anchor link
						echo '<a name="' . $location->name . '"></a>';
							
							
							
							echo '<div class="ndi_dance_styles" for="tab-' . $count . '">';
								
								echo '<div class="title">' . $location->name . '</div>';
								
								if($image) {
								echo '<img src="' . $image . '" />';
								};
								
								
								echo '<div class="desc">' . $location->description . '</div>';
								
							echo '</div>';
					
					echo '<div class="class_calendar" id="tab-content-' . $count . '">';
					
				
					 
						// Start the Loop
						
				 
						
                        	$days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
                        	foreach ($days as $day) {
								
											echo '<li class="ndi_dance_day">';
											echo '<div class="day_title">' . $day . '</div>';			
                        
                        					while ( $query->have_posts() ) : $query->the_post();
											
											if (get_field('class_days')) {
											$class_days = get_field('class_days');
											
											foreach( $class_days as $class_day ) {
												
												if ($day == $class_day) {
												
													$start_time = get_field('start_time', $query->post->ID);
													$start_time = ltrim($start_time, '0');
													$end_time = get_field('end_time', $query->post->ID);
													$studio = get_field('studio', $query->post->ID);
													$teacher = get_field('teacher', $query->post->ID);
													$ages = get_field('age_range', $query->post->ID);
													$image = get_field('image', $query->post->ID);
													$image_size = 'medium';
													$post_link = get_post_permalink($query->post->ID);
													$color = get_field('class_color', $query->post->ID);													
															
															
															echo '<a href="' . esc_url( $post_link ) . '">';
															echo '<div class="dance_class">';
															echo '<ul>';
															
															
															
															echo '<li style=' . '"background-color:' . $color . ';">';
																/* if( $image ) :
																	echo '<div class="class_image">';
																	echo wp_get_attachment_image( $image, $image_size );
																	echo '</div>';
																endif;
																*/
																echo '<span class="title">' . get_the_title( $query->post->ID ) . '</span>';
																
																
																echo '<span class="lable">Time:</span>' . '<span class="class_meta">' .  $start_time . ' - ' . $end_time . '</span>';
																
																
																echo '<br class="clear">';
																if( $teacher ) :
																echo '<span class="lable">Teacher:</span>';
																echo '<span class="class_meta">';
																echo $teacher;
																echo '</span>';
																endif;
																
																echo '<br class="clear">';
																if( $ages ) :
																echo '<span class="lable">Ages:</span>';
																echo '<span class="class_meta">';
																echo $ages;
																echo '</span>';
																endif;
																
																echo '<br class="clear">';
																if( $studio ) :
																echo '<span class="lable">Studio:</span>';
																echo '<span class="class_meta">';
																echo $studio;
																echo '</span>';
																endif;
																
																echo '<br class="clear">';
																
																
																
																
															
															
															echo '</ul>';
															echo '</div>';
															echo '</a>';
															
															
														};
															
												
                        
												};
                        
                        
                        					};
                        
                        		
                       				 endwhile;
							 echo '</li>';
                        	}; //end for each class_days
                        		
                      
                        }; 
						 
						
					 
					echo '</div>';
					

					// use reset postdata to restore orginal query
					wp_reset_postdata();
				 
				};
				
				
				
			
			
	
			
		

		?>
        </article>
        <hr class="clear">
		<?php
		wp_reset_postdata();
		
		
		
		?>
		
		
       
    