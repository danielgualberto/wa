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

    'accepted' => 'O :attribute deve ser aceito.',
    'accepted_if' => 'O :attribute deve ser aceito quando :other for :value.',
    'active_url' => 'O :attribute não é um URL válido.',
    'after' => 'O :attribute deve ser uma data posterior a :date.',
    'after_or_equal' => 'O :attribute deve ser uma data posterior ou igual a :date.',
    'alpha' => 'O :attribute deve conter apenas letras.',
    'alpha_dash' => 'O :attribute deve conter apenas letras, números, traços e sublinhados.',
    'alpha_num' => 'O :attribute deve conter apenas letras e números.',
    'array' => 'O :attribute deve ser um array.',
    'before' => 'O :attribute deve ser uma data anterior a :date.',
    'before_or_equal' => 'O :attribute deve ser uma data anterior ou igual a :date.',
    'between' => [
    'numeric' => 'O :attribute deve estar entre :min e :max.',
    'file' => 'O :attribute deve estar entre :min e :max kilobytes.',
    'string' => 'O :attribute deve estar entre :min e :max caracteres.',
    'array' => 'O :attribute deve ter entre :min e :max itens.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'A confirmação :attribute não corresponde.',
    'current_password' => 'A senha está incorreta.',
    'date' => 'O :attribute não é uma data válida.',
    'date_equals' => 'O :attribute deve ser uma data igual a :date.',
    'date_format' => 'O :attribute não corresponde ao formato :format.',
    'declined' => 'O :attribute deve ser recusado.',
    'declined_if' => 'O :attribute deve ser recusado quando :other for :value.',
    'different' => 'O :attribute e :other devem ser diferentes.',
    'digits' => 'O :attribute deve ser :digits dígitos.',
    'digits_between' => 'O :attribute deve estar entre :min e :max dígitos.',
    'dimensions' => 'O :attribute tem dimensões de imagem inválidas.',
    'distinct' => 'O campo :attribute tem um valor duplicado.',
    'email' => 'O :attribute deve ser um endereço de e-mail válido.',
    'ends_with' => 'O :attribute deve terminar com um dos seguintes: :values.',
    'enum' => 'O :attribute selecionado é inválido.',
    'exists' => 'O :attribute selecionado é inválido.',
    'file' => 'O :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve ter um valor.',
    'gt' => [
    'numeric' => 'O :attribute deve ser maior que :value.',
    'file' => 'O :attribute deve ser maior que :value kilobytes.',
    'string' => 'O :attribute deve ser maior que os caracteres :value.',
    'array' => 'O :attribute deve ter mais de :value itens.',
    ],
    'gte' => [
    'numeric' => 'O :attribute deve ser maior ou igual a :value.',
    'file' => 'O :attribute deve ser maior ou igual a :value kilobytes.',
    'string' => 'O :attribute deve ser maior ou igual a :value caracteres.',
    'array' => 'O :attribute deve ter itens :value ou mais.',
    ],
    'image' => 'O :attribute deve ser uma imagem.',
    'in' => 'O :attribute selecionado é inválido.',
    'in_array' => 'O campo :attribute não existe em :other.',
    'integer' => 'O :attribute deve ser um número inteiro.',
    'ip' => 'O :attribute deve ser um endereço IP válido.',
    'ipv4' => 'O :attribute deve ser um endereço IPv4 válido.',
    'ipv6' => 'O :attribute deve ser um endereço IPv6 válido.',
    'json' => 'O :attribute deve ser uma string JSON válida.',
    'lt' => [
    'numeric' => 'O :attribute deve ser menor que :value.',
    'file' => 'O :attribute deve ser menor que :value kilobytes.',
    'string' => 'O :attribute deve ser menor que :value caracteres.',
    'array' => 'O :attribute deve ter itens menores que :value.',
    ],
    'lte' => [
    'numeric' => 'O :attribute deve ser menor ou igual a :value.',
    'file' => 'O :attribute deve ser menor ou igual a :value kilobytes.',
    'string' => 'O :attribute deve ser menor ou igual a :value caracteres.',
    'array' => 'O :attribute não deve ter mais do que :value itens.',
    ],
    'mac_address' => 'O :attribute deve ser um endereço MAC válido.',
    'max' => [
    'numeric' => 'O :attribute não deve ser maior que :max.',
    'file' => 'O :attribute não deve ser maior que :max kilobytes.',
    'string' => 'O :attribute não deve ser maior que :max caracteres.',
    'array' => 'O :attribute não deve ter mais do que :max itens.',
    ],
    'mimes' => 'O :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O :attribute deve ser um arquivo do tipo: :values.',
    'min' => [
    'numeric' => 'O :attribute deve ser pelo menos :min.',
    'file' => 'O :attribute deve ter pelo menos :min kilobytes.',
    'string' => 'O :attribute deve ter pelo menos :min caracteres.',
    'array' => 'O :attribute deve ter pelo menos :min itens.',
    ],
    'multiple_of' => 'O :attribute deve ser um múltiplo de :value.',
    'not_in' => 'O :attribute selecionado é inválido.',
    'not_regex' => 'O formato :attribute é inválido.',
    'numeric' => 'O :attribute deve ser um número.',
    'password' => 'A senha está incorreta.',
    'present' => 'O campo :attribute deve estar presente.',
    'prohibited' => 'O campo :attribute é proibido.',
    'prohibited_if' => 'O campo :attribute é proibido quando :other é :value.',
    'prohibited_unless' => 'O campo :attribute é proibido a menos que :other esteja em :values.',
    'prohibits' => 'O campo :attribute proíbe :other de estar presente.',
    'regex' => 'O formato :attribute é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_array_keys' => 'O campo :attribute deve conter entradas para: :values.',
    'required_if' => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless' => 'O campo :attribute é obrigatório, a menos que :other esteja em :values.',
    'required_with' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando :values estão presentes.',
    'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values está presente.',
    'same' => 'O :attribute e :other devem corresponder.',
    'size' => [
    'numeric' => 'O :attribute deve ser :size.',
    'file' => 'O :attribute deve ser :size kilobytes.',
    'string' => 'O :attribute deve ser :size caracteres.',
    'array' => 'O :attribute deve conter itens :size.',
    ],
    'starts_with' => 'O :attribute deve começar com um dos seguintes: :values.',
    'string' => 'O :attribute deve ser uma string.',
    'timezone' => 'O :attribute deve ser um fuso horário válido.',
    'unique' => 'O :attribute já foi usado.',
    'uploaded' => 'O :attribute falhou ao carregar.',
    'url' => 'O :attribute deve ser um URL válido.',
    'uuid' => 'O :attribute deve ser um UUID válido.',

    'keyword_already_exists' => 'A palavra-chave já existe no mesmo número.',
    'autoreply_added' => 'Sua resposta automática foi adicionada!',
    'autoreply_allowext' => 'Somente extensões jpg, png e jpeg são permitidas!',
    'autoreply_allowtemplate' => 'Os Templates não são válidos!',
    'autoreply_error' => 'Ocorreu um erro, favor entrar em contato pelo',
    'tag_added' => 'Lista adicionada!',
    'tag_deleted' => 'Lista deletada!',
    'tag_sender_not_connected' => 'O seu remetente não está conectado!',
    'tag_generate_success' => 'Gerado com sucesso!',
    'tag_alert_delete' => 'Tem certeza que deseja deletar esta lista? (Todos os contatos nesta lista também serão deletados!)',
    'contacts_added' => 'Contato adicionado!',
    'contacts_import_success' => 'Importado com sucesso!',
    'contacts_import_error' => 'Erro ao importar!',
    'contacts_deleted_all' => 'Todos os contatos foram deletados.',
    'contacts_deleted' => 'Contato #',
    'contacts_deleted_' => 'deletado.',
    'campaign_required_name' => 'Nome da Campanha é obrigatório.',
    'campaign_required_delay' => 'O Delay (atraso) é obrigatório.',
    'campaign_req_fill_datetime' => 'Por favor, preencha data e hora.',
    'campaign_req_type_message' => 'Por favor, selecione o tipo de mensagem.',
    'campaign_req_message' => 'Por favor, preencha o campo da mensagem.',
    'campaign_req_image' => 'Por favor, preencha o campo da imagem.',
    'campaign_req_button' => 'Por favor, preencha o campo do botão 1.',
    'campaign_req_button_add' => 'Você tem que adicionar pelo menos 1 botão.',
    'campaign_req_template' => 'Por favor, preencha o campo do template 1.',
    'campaign_req_template_not_valid' => 'O Template não é válido.',
    'campaign_req_list_button' => 'Por favor, preencha o campo do botão da lista.',
    'campaign_req_list_name' => 'Por favor, preencha o campo do nome da lista.',
    'campaign_req_list_title' => 'Por favor, preencha o campo do título da lista.',
    'campaign_req_list' => 'Por favor, preencha o campo da lista #1.',
    'campaign_req_list_add' => 'Você tem que adicionar pelo menos 1 lista.',
    'campaign_req_list_select' => 'Você tem que selecionar pelo menos 1 lista.',
    'campaign_sending' => 'Criando...',
    'campaign_deleted_all' => 'Todas as campanhas foram deletadas.',
    'campaign_paused' => 'Campanha pausada.',
    'campaign_resumed' => 'Campanha retomada.',
    'campaign_another' => 'Você tem outra campanha com o status de processando ou aguardando.',
    'campaign_same_sender' => 'Existe uma campanha com o mesmo remetente, aguarde até que a campanha seja finalizada.',
    'campaign_recipients_not_match' => 'O número do destinatário não corresponde.',
    'sender_not_connected' => 'O remetente não está conectado!',
    'allowed_extensions_image' => 'Somente extensões jpg, png e jpeg são permitidas!',
    'allowed_type_file' => 'Tipo de arquivo não permitido.',
    'allowed_type_image' => 'Tipo de imagem não permitida.',
    'blast_message_scheduled_success' => 'Disparo de mensagem criado com sucesso!',
    'error_occured' => 'Ops! Ocorreu um erro. Tente novamente mais tarde.',
    'error_server_node' => 'Há um problema no servidor node.',
    'message_sent' => 'Mensagem enviada',
    'no_buttons_selected' => 'Nenhum botão selecionado.',
    'no_template_selected' => 'Nenhum template selecionado.',
    'no_list_selected' => 'Nenhuma lista selecionada.',
    'template_not_valid' => 'O Template não é válido.',
    'node_already_running' => 'Certifique-se de que o Node do seu servidor já esteja em execução!',
    'register_success' => 'Registrado com sucesso! Agora você pode fazer o login.',
    'reached_limit_devices' => 'Você atingiu seu limite de dispositivos.',
    'device_added' => 'Dispositivo Adicionado!',
    'device_deleted' => 'Dispositivo Deletado!',
    'invalid_type_media' => 'Tipo de mídia inválido!',
    'wrong_api_key' => 'Chave de API incorreta!',
    'wrong_credentials' => 'Algo de errado com os seus dados de login.',
    'wrong_parameters' => 'Parâmetros errados!',
    'wrong_password_current' => 'A senha atual está incorreta.',
    'wrong_type_template' => 'Tipo de template incorreto:',
    'wrong_type_template_' => 'Tipo de template incorreto!',
    'not_valid_type_template' => 'O tipo de template é inválido:',
    'subscription_expired_greater' => 'A assinatura expirada deve ser maior do que hoje.',
    'user_created' => 'Usuário criado.',
    'user_updated' => 'Usuário atualizado.',
    'user_delete_is_admin' => 'Você não pode deletar o admin.',
    'user_deleted' => 'Usuário deletado.',
    'password_changed' => 'Senha alterada.',
    'password_leave_blank' => 'Senha *(deixe em branco se não quiser alterar).',
    'api_key_new_set_success' => 'Nova chave de API definida com sucesso.',
    'chunk_change' => 'Alterado com sucesso.',
    'req_fill_all_field' => 'Por favor, preencha todos os campos!',
    'req_set_datetime_type_schedule' => 'Por favor, defina a data e hora se o tipo da mensagem for programada.',
    'req_fill_or_number_all_tag' => 'Por favor, preencha o número ou selecione todos, ou selecione a lista!',
    'type_template_must_call_url' => 'O tipo de template pode ser chamada (call) ou link (url).',
    'alert_delete_user' => 'Tem certeza que irá deletar este usuário? Todos os dados do usuário também serão deletados.',

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
