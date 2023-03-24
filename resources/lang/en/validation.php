<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
    'numeric' => 'The :attribute must be between :min and :max.',
    'file' => 'The :attribute must be between :min and :max kilobytes.',
    'string' => 'The :attribute must be between :min and :max characters.',
    'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
    'numeric' => 'The :attribute must be greater than :value.',
    'file' => 'The :attribute must be greater than :value kilobytes.',
    'string' => 'The :attribute must be greater than :value characters.',
    'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
    'numeric' => 'The :attribute must be greater than or equal to :value.',
    'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
    'string' => 'The :attribute must be greater than or equal to :value characters.',
    'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
    'numeric' => 'The :attribute must be less than :value.',
    'file' => 'The :attribute must be less than :value kilobytes.',
    'string' => 'The :attribute must be less than :value characters.',
    'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
    'numeric' => 'The :attribute must be less than or equal to :value.',
    'file' => 'The :attribute must be less than or equal to :value kilobytes.',
    'string' => 'The :attribute must be less than or equal to :value characters.',
    'array' => 'The :attribute must not have more than :value items.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
    'numeric' => 'The :attribute must not be greater than :max.',
    'file' => 'The :attribute must not be greater than :max kilobytes.',
    'string' => 'The :attribute must not be greater than :max characters.',
    'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
    'numeric' => 'The :attribute must be at least :min.',
    'file' => 'The :attribute must be at least :min kilobytes.',
    'string' => 'The :attribute must be at least :min characters.',
    'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
    'numeric' => 'The :attribute must be :size.',
    'file' => 'The :attribute must be :size kilobytes.',
    'string' => 'The :attribute must be :size characters.',
    'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    'keyword_already_exists' => 'The keyword already exists in the same number.',
    'autoreply_added' => 'Your autoresponder has been added!',
    'autoreply_allowext' => 'Only jpg, png and jpeg extensions are allowed!',
    'autoreply_allowtemplate' => 'Templates are not valid!',
    'autoreply_error' => 'An error occurred, please contact us at',
    'tag_added' => 'List added!',
    'tag_deleted' => 'List deleted!',
    'tag_sender_not_connected' => 'Your sender is not connected!',
    'tag_generate_success' => 'Generated successfully!',
    'tag_alert_delete' => 'Are you sure you want to delete this list? (All contacts in this list will also be deleted!)',
    'contacts_added' => 'Contact added!',
    'contacts_import_success' => 'Imported successfully!',
    'contacts_import_error' => 'Error importing!',
    'contacts_deleted_all' => 'All contacts have been deleted.',
    'contacts_deleted' => 'Contact #',
    'contacts_deleted_' => 'deleted.',
    'campaign_required_name' => 'Broadcast Name is required.',
    'campaign_required_delay' => 'Delay is required.',
    'campaign_req_fill_datetime' => 'Please fill in date and time.',
    'campaign_req_type_message' => 'Please select message type.',
    'campaign_req_message' => 'Please fill in the message field.',
    'campaign_req_image' => 'Please fill in the image field.',
    'campaign_req_button' => 'Please fill in the field of button 1.',
    'campaign_req_button_add' => 'You have to add at least 1 button.',
    'campaign_req_template' => 'Please fill in the template field 1.',
    'campaign_req_template_not_valid' => 'Template is not valid.',
    'campaign_req_list_button' => 'Please fill in the list button field.',
    'campaign_req_list_name' => 'Please fill in the list name field.',
    'campaign_req_list_title' => 'Please fill in the list title field.',
    'campaign_req_list' => 'Please fill in the list field #1.',
    'campaign_req_list_add' => 'You have to add at least 1 list.',
    'campaign_req_list_select' => 'You have to select at least 1 list.',
    'campaign_sending' => 'Creating...',
    'campaign_deleted_all' => 'All broadcasts have been deleted.',
    'campaign_paused' => 'Broadcast paused.',
    'campaign_resumed' => 'Broadcast resumed.',
    'campaign_another' => 'You have another broadcast with a status of processing or waiting.',
    'campaign_same_sender' => 'There is a broadcast with the same sender, wait until the broadcast ends.',
    'campaign_recipients_not_match' => 'Recipient number does not match.',
    'sender_not_connected' => 'The sender is not connected!',
    'allowed_extensions_image' => 'Only jpg, png and jpeg extensions are allowed!',
    'allowed_type_file' => 'File type not allowed.',
    'allowed_type_image' => 'Image type not allowed.',
    'blast_message_scheduled_success' => 'Message trigger successfully created!',
    'error_occured' => 'Oops! An error has occurred. Try again later.',
    'error_server_node' => 'There is a problem on the node server.',
    'message_sent' => 'Message sent',
    'no_buttons_selected' => 'No button selected.',
    'no_template_selected' => 'No template selected.',
    'no_list_selected' => 'No list selected.',
    'template_not_valid' => 'Template is not valid.',
    'node_already_running' => 'Make sure your server's Node is already running!',
    'register_success' => 'Successfully registered! Now you can login.',
    'reached_limit_devices' => 'You have reached your device limit.',
    'device_added' => 'Device Added!',
    'device_deleted' => 'Device Deleted!',
    'invalid_type_media' => 'Invalid media type!',
    'wrong_api_key' => 'Incorrect API key!',
    'wrong_credentials' => 'Something is wrong with your login details.',
    'wrong_parameters' => 'Wrong parameters!',
    'wrong_password_current' => 'The current password is incorrect.',
    'wrong_type_template' => 'Incorrect template type:',
    'wrong_type_template_' => 'Incorrect template type!',
    'not_valid_type_template' => 'The template type is invalid:',
    'subscription_expired_greater' => 'The expired subscription must be greater than today.',
    'user_created' => 'User created.',
    'user_updated' => 'User updated.',
    'user_delete_is_admin' => 'You cannot delete the admin.',
    'user_deleted' => 'User deleted.',
    'password_changed' => 'Password changed.',
    'password_leave_blank' => 'Password * (leave it blank if you don't want to change it).',
    'api_key_new_set_success' => 'New API key set successfully.',
    'chunk_change' => 'Changed successfully.',
    'req_fill_all_field' => 'Please fill in all fields!',
    'req_set_datetime_type_schedule' => 'Please set the date and time if the message type is 'scheduled'.',
    'req_fill_or_number_all_tag' => 'Please fill in the number or select all, or select the list!',
    'type_template_must_call_url' => 'The template type can be call (call) or link (url).',
    'alert_delete_user' => 'Are you sure you are going to delete this user? All user data will also be deleted.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
