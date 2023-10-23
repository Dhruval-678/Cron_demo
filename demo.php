<?php

/**
 * Daily checking of users role
 */
// cron for changing roles of cutomers to wholesalers
if (! wp_next_scheduled('vino_change_role_to_engros') ) {
    wp_schedule_event(time(), 'daily', 'vino_change_role_to_engros');
}

add_action('vino_change_role_to_engros', 'Vino_change_role_to_engros_function');

/** 
 * Change role to Wholesler
 */
function Vino_Change_Role_To_Engros_Function()
{
    $user_query = new WP_User_Query(array( 'role' => 'Customer' ));
    if (! empty($user_query->get_results()) ) {
        foreach ( $user_query->get_results() as $user ) {
            $customer_role = get_field('customer_role', 'user_'.$user->ID);
            if ($customer_role == 'engros') {
                $user->remove_role('customer');
                $user->add_role('engros');
            }
        }
    }
}

?>
