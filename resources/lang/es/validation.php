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

    'accepted' => 'El :attribute deve ser aceptado',
    'accepted_if' => 'El :attribute debe ser aceptado cuando :other es :value.',
    'active_url' => 'El :attribute no es una URL valida.',
    'after' => 'El :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El :attribute debe ser una fecha posterior o la misma a :date.',
    'alpha' => 'El :attribute debe contener solo letras.',
    'alpha_dash' => 'El :attribute debe contener solo letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El :attribute debe contener solo letras y números.',
    'array' => 'El :attribute debe ser una matriz.',
    'before' => 'El :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha anterior o la misma a :date.',
    'between' => [
    'numeric' => 'El :attribute debe estar entre :min y :max.',
    'file' => 'El :attribute debe estar entre :min y :max kilobytes.',
    'string' => 'El :attribute debe estar entre :min y :max caracteres.',
    'array' => 'El :attribute debe tener entre :min y :max elementos.',
    ],
    'boolean' => 'El campo :attribute deve ser verdadero o falso.',
    'confirmed' => 'La confirmación :attribute no coincide.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => 'El :attribute no es una fecha válida.',
    'date_equals' => 'El :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El :attribute no coincide con el formato :format.',
    'declined' => 'El :attribute debe ser rechazado.',
    'declined_if' => 'El :attribute debe rechazarse cuando :other es :value.',
    'different' => 'Los :attribute y :other deben ser diferentes.',
    'digits' => 'El :attribute debe tener :digits dígitos.',
    'digits_between' => 'El :attribute debe estar entre :min y :max dígitos.',
    'dimensions' => 'El :attribute tiene dimensiones de image no válidas.',
    'distinct' => 'El campo :attribute tiene un valor duplicado.',
    'email' => 'El :attribute debe ser una dirección de correo eletrónico válida.',
    'ends_with' => 'El :attribute debe terminar con umo de los seguientes: :values.',
    'enum' => 'El :attribute seleccionado no es válido.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'file' => 'El :attribute debe ser un archivo.',
    'filled' => 'El campo :attribute debe tener un valor.',
    'gt' => [
    'numeric' => 'El :attribute debe ser mayor que el :value.',
    'file' => 'El :attribute debe ser mayor que el :value kilobytes.',
    'string' => 'El :attribute debe ser mayor que los caracteres :value.',
    'array' => 'El :attribute debe tener más de :value elementos.',
    ],
    'gte' => [
    'numeric' => 'El :attribute debe ser mayor o lo mismo que :value.',
    'file' => 'El :attribute debe ser mayor o lo mismo que :value kilobytes.',
    'string' => 'El :attribute debe ser mayor o lo mismo que :value caracteres.',
    'array' => 'El :attribute debe tener elementos :value o más.',
    ],
    'image' => 'El :attribute debe ser una imagen.',
    'in' => 'El :attribute seleccionado no es válido.',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => 'El :attribute debe ser un número entero.',
    'ip' => 'El :attribute debe ser una dirección IP válida.',
    'ipv4' => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El :attribute debe ser una dirección IPv6 válida.',
    'json' => 'El :attribute debe ser una cadena JSON válida.',
    'lt' => [
    'numeric' => 'El :attribute debe ser menor que :value.',
    'file' => 'El :attribute debe ser menor que :value kilobytes.',
    'string' => 'El :attribute debe ser menor que :value caracteres.',
    'array' => 'El :attribute debe tener elementos menores que :value.',
    ],
    'lte' => [
    'numeric' => 'El :attribute debe ser menor o lo mismo que :value.',
    'file' => 'El :attribute debe ser menor o lo mismo que :value kilobytes.',
    'string' => 'El :attribute debe ser menor o lo mismo que :value caracteres.',
    'array' => 'El :attribute no debe tener más de :value elementos.',
    ],
    'mac_address' => 'El :attribute debe ser una dirección MAC válida.',
    'max' => [
    'numeric' => 'El :attribute no debe ser mayor que :max.',
    'file' => 'El :attribute no debe ser mayor que :max kilobytes.',
    'string' => 'El :attribute no debe ser mayor que :max caracteres.',
    'array' => 'El :attribute no debe tener más de :max elementos.',
    ],
    'mimes' => 'El :attribute debe ser un archivo de tipo :values.',
    'mimetypes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'min' => [
    'numeric' => 'El :attribute debe ser al menos :min.',
    'file' => 'El :attribute debe tener al menos :min kilobytes.',
    'string' => 'El :attribute debe tener al menos :min caracteres.',
    'array' => 'El :attribute debe tener al menos :min elementos.',
    ],
    'multiple_of' => 'El :attribute debe ser un múltiplo de :value.',
    'not_in' => 'El :attribute seleccionado no es válido.',
    'not_regex' => 'El formato de :attribute no es válido.',
    'numeric' => 'El :attribute debe ser un número.',
    'password' => 'La contraseña es incorrecta.',
    'present' => 'El campo :attribute debe estar presente.',
    'prohibited' => 'El campo :attribute está prohibido.',
    'prohibited_if' => 'El campo :attribute está prohibido cuando :other es :value.',
    'prohibited_unless' => 'El campo :attribute está prohibido a menos que :other esté en :values.',
    'prohibits' => 'El campo :attribute prohíbe que :other esté presente.',
    'regex' => 'El formato :attribute no es válido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_array_keys' => 'El campo :attribute debe contener entradas para: :values.',
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless' => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando los :values están presentes.',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de los :values están presentes.',
    'same' => 'El :attribute y :other deben coincidir.',
    'size' => [
    'numeric' => 'El :attribute debe ser :size.',
    'file' => 'El :attribute debe ser :size kilobytes.',
    'string' => 'El :attribute debe ser :size caracteres.',
    'array' => 'El :attribute debe contener elementos :size.',
    ],
    'starts_with' => 'El :attribute debe comenzar con uno de los siguientes: :values.',
    'string' => 'El :attribute debe ser una cadena.',
    'timezone' => 'El :attribute debe ser una zona horaria válida.',
    'unique' => 'El :attribute ya se ha utilizado.',
    'uploaded' => 'El :attribute no se pudo cargar.',
    'url' => 'El :attribute debe ser una URL válida.',
    'uuid' => 'El :attribute debe ser un UUID válido.',

    'keyword_already_exists' => 'La palabra clave ya existe en el mismo número.',
    'autoreply_added' => '¡Tu respuesta automática ha sido añadida!',
    'autoreply_allowext' => '¡Solo se permiten las extensiones jpg, png y jpeg!',
    'autoreply_allowtemplate' => '¡Los modelos no son válidos!',
    'autoreply_error' => 'Ocurrió un error, por favor contáctenos al',
    'tag_added' => '¡Lista añadida!',
    'tag_deleted' => '¡Lista eliminada!',
    'tag_sender_not_connected' => '¡Tu remitente no ha iniciado sesión!',
    'tag_generate_success' => '¡Generado con éxito!',
    'tag_alert_delete' => '¿Está seguro de que desea eliminar esta lista? (¡Todos los contactos en esta lista también serán eliminados!)',
    'contacts_added' => '¡Contacto añadido!',
    'contacts_import_success' => '¡Importado con éxito!',
    'contacts_import_error' => '¡Error al importar!',
    'contacts_deleted_all' => 'Todos los contactos han sido eliminados.',
    'contacts_deleted' => 'Contacto #',
    'contacts_deleted_' => 'eliminado.',
    'campaign_required_name' => 'El nombre de la Campaña es obligatorio.',
    'campaign_required_delay' => 'Se requiere demora.',
    'campaign_req_fill_datetime' => 'Por favor complete la fecha y la hora.',
    'campaign_req_type_message' => 'Por favor seleccione el tipo de mensaje.',
    'campaign_req_message' => 'Por favor complete el campo de mensaje.',
    'campaign_req_image' => 'Por favor, rellene el campo de la imagen.',
    'campaign_req_button' => 'Por favor complete el campo del botón 1.',
    'campaign_req_button_add' => 'Tienes que añadir al menos 1 botón.',
    'campaign_req_template' => 'Por favor complete el campo del modelo 1.',
    'campaign_req_template_not_valid' => 'El modelo no es válido.',
    'campaign_req_list_button' => 'Por favor complete el campo del botón de lista.',
    'campaign_req_list_name' => 'Por favor, rellene el campo de nombre de la lista.',
    'campaign_req_list_title' => 'Por favor, rellene el campo de título de la lista.',
    'campaign_req_list' => 'Por favor complete el campo de lista #1.',
    'campaign_req_list_add' => 'Tienes que añadir al menos 1 lista.',
    'campaign_req_list_select' => 'Tienes que seleccionar al menos 1 lista.',
    'campaign_sending' => 'Creando...',
    'campaign_deleted_all' => 'Se han eliminado todas las campañas.',
    'campaign_paused' => 'Campaña en pausa.',
    'campaign_resumed' => 'Se reanudó la campaña.',
    'campaign_another' => 'Tienes otra campaña en estado de procesamiento o en espera.',
    'campaign_same_sender' => 'Hay una campaña con el mismo remitente, espere a que finalice la campaña.',
    'campaign_recipients_not_match' => 'El número de destinatario no coincide.',
    'sender_not_connected' => '¡El remitente no está conectado!',
    'allowed_extensions_image' => '¡Solo se permiten las extensiones jpg, png y jpeg!',
    'allowed_type_file' => 'Tipo de archivo no permitido.',
    'allowed_type_image' => 'Tipo de imagen no permitido.',
    'blast_message_scheduled_success' => 'Activador de mensaje creado con éxito.',
    'error_occured' => '¡Ups! Ocurrio un error. Vuelva a intentarlo más tarde.',
    'error_server_node' => 'Hay un problema en el servidor del Node.',
    'message_sent' => 'Mensage enviada',
    'no_buttons_selected' => 'Ningún botón seleccionado.',
    'no_template_selected' => 'Ningún modelo seleccionado.',
    'no_list_selected' => 'Ninguna lista seleccionada.',
    'template_not_valid' => 'El modelo no es válido.',
    'node_already_running' => '¡Asegúrese de que el Node de su servidor ya se esté ejecutando!',
    'register_success' => '¡Registrado con éxito! Ahora puede iniciar sesión.',
    'reached_limit_devices' => 'Ha alcanzado el límite de su dispositivo.',
    'device_added' => '¡Dispositivo Añadido!',
    'device_deleted' => '¡Dispositivo Eliminado!',
    'invalid_type_media' => '¡Tipo de medio no válido!',
    'wrong_api_key' => '¡Clave de API incorrecta!',
    'wrong_credentials' => 'Algo está mal con sus datos de inicio de sesión.',
    'wrong_parameters' => '¡Parámetros erróneos!',
    'wrong_password_current' => 'La contraseña actual es incorrecta.',
    'wrong_type_template' => 'Tipo de modelo incorrecto:',
    'wrong_type_template_' => '¡Tipo de modelo incorrecto!',
    'not_valid_type_template' => 'El tipo de modelo no es válido:',
    'subscription_expired_greater' => 'La suscripción caducada debe ser superior a la actual.',
    'user_created' => 'Usuario creado.',
    'user_updated' => 'Usuario actualizado.',
    'user_delete_is_admin' => 'No puede eliminar el administrador.',
    'user_deleted' => 'Usuario eliminado.',
    'password_changed' => 'Se cambió tu contraseña.',
    'password_leave_blank' => 'Contraseña * (déjelo en blanco si no desea cambiarla).',
    'api_key_new_set_success' => 'Nueva clave de API configurada con éxito.',
    'chunk_change' => 'Cambiado con éxito.',
    'req_fill_all_field' => '¡Por favor rellena todos los campos!',
    'req_set_datetime_type_schedule' => 'Configure la fecha y la hora si el tipo de mensaje está programado.',
    'req_fill_or_number_all_tag' => '¡Por favor complete el número o seleccione todo, o seleccione la lista!',
    'type_template_must_call_url' => 'El tipo de modelo puede ser llamada (call) o enlace (url).',
    'alert_delete_user' => '¿Estás seguro de que vas a eliminar a este usuario? Todos los datos del usuario también serán eliminados.',

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
