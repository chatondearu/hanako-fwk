-- INSERTION D'UNE COMMANDE

--  -- insert command
  INSERT INTO `soft_commands` (
    `id_commands`,
    `nmb_code_user_commands`,
    `nmb_delivery_commands`,
    `date_commands`,
    `delivery_adress_id_commands`,
    `payoff_amout_commands`,
    `payoff_order_commands`
  ) VALUES (
     NULL,
     '',
     '',
     CURRENT_TIMESTAMP,
     '',
     '',
     ''
  );

--  insert command type
  INSERT INTO `soft_state_commands` (
    `id_state_commands`,
    `type_id_state_commands`, 
    `date_state_commands`
  ) VALUES (
    NULL,
    '',
    CURRENT_TIMESTAMP
  );

-- insert articles

  INSERT INTO `soft_articles` (
    `id_articles`,
    `commands_id_articles`,
    `nmb_line_articles`,
    `reference_articles`,
    `designation_articles`,
    `quantity_articles`
  ) VALUES (
    NULL,
    '',
    '',
    '',
    '',
    ''
  );