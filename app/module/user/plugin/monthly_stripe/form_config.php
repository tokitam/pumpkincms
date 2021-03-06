<?php

$GLOBALS['pumpform_config']['user']['payment_monthly_stripe_customer'] = array(
    'module' => 'user',
    'title' => 'payment_monthly_stripe_customer',
    'table' => 'payment_monthly_stripe_customer',

    'column' => array(

        'user_id' => array('name' => 'user_id',
                         'type' => PUMPFORM_INT,
                         'title' => 'user_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'customer_id' => array('name' => 'customer_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'customer_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'account_balance' => array('name' => 'account_balance',
                         'type' => PUMPFORM_INT,
                         'title' => 'account_balance',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'created' => array('name' => 'created',
                         'type' => PUMPFORM_INT,
                         'title' => 'created',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'currency' => array('name' => 'currency',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'currency',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'email' => array('name' => 'email',
                         'type' => PUMPFORM_EMAIL,
                         'title' => 'email',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'card_id' => array('name' => 'card_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'card_i',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        ),
);

$GLOBALS['pumpform_config']['user']['payment_monthly_stripe_subscription'] = array(
    'module' => 'user',
    'title' => 'payment_monthly_stripe_subscription',
    'table' => 'payment_monthly_stripe_subscription',

    'column' => array(

        'user_id' => array('name' => 'user_id',
                         'type' => PUMPFORM_INT,
                         'title' => 'user_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'subscription_id' => array('name' => 'subscription_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'subscription_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'billing' => array('name' => 'billing',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'billing',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'cancel_at_period_end' => array('name' => 'cancel_at_period_end',
                         'type' => PUMPFORM_INT,
                         'title' => 'cancel_at_period_end',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'canceled_at' => array('name' => 'canceled_at',
                         'type' => PUMPFORM_INT,
                         'title' => 'canceled_at',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'created' => array('name' => 'created',
                         'type' => PUMPFORM_INT,
                         'title' => 'created',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'current_period_end' => array('name' => 'current_period_end',
                         'type' => PUMPFORM_INT,
                         'title' => 'current_period_end',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'current_period_start' => array('name' => 'current_period_start',
                         'type' => PUMPFORM_INT,
                         'title' => 'current_period_start',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'customer_id' => array('name' => 'customer_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'customer_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'ended_at' => array('name' => 'ended_at',
                         'type' => PUMPFORM_INT,
                         'title' => 'ended_at',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'subscription_item_id' => array('name' => 'subscription_item_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'subscription_item_id',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'plan_id' => array('name' => 'plan_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'plan_id',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'project_id' => array('name' => 'project_id',
                         'type' => PUMPFORM_INT,
                         'title' => 'project_id',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,
                         'default' => 0),
        ),
);

$GLOBALS['pumpform_config']['user']['payment_monthly_stripe_webhook'] = array(
    'module' => 'user',
    'title' => 'payment_monthly_stripe_webhook',
    'table' => 'payment_monthly_stripe_webhook',

    'column' => array(

        'user_id' => array('name' => 'user_id',
                         'type' => PUMPFORM_INT,
                         'title' => 'user_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'event_id' => array('name' => 'event_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'event_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'type' => array('name' => 'type',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'type',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'subscription_id' => array('name' => 'subscription_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'subscription_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'customer_id' => array('name' => 'customer_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'customer_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'subscription_item_id' => array('name' => 'subscription_item_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'subscription_item_id',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'plan_id' => array('name' => 'plan_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'plan_id',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'charge_id' => array('name' => 'charge_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'charge_id',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'invoice_id' => array('name' => 'invoice_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'invoice_id',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'source_id' => array('name' => 'source_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'source_id',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        ),
);

$GLOBALS['pumpform_config']['user']['payment_monthly_stripe_plan'] = array(
    'module' => 'user',
    'title' => 'payment_monthly_stripe_plan',
    'table' => 'payment_monthly_stripe_plan',
																		   
    'add_path' => '/user/payment/?type=monthly_stripe&action=plan_add',
    'edit_path' => '/user/payment/?type=monthly_stripe&action=plan_edit&id=%s',
    'detail_path' => '/user/payment/?type=monthly_stripe&action=plan_detail&id=%s',
    'delete_path' => '/user/payment/?type=monthly_stripe&action=plan_delete&id=%s',

    'column' => array(

        'plan_id' => array('name' => 'plan_id',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'plan_id',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'amount' => array('name' => 'amount',
                         'type' => PUMPFORM_INT,
                         'title' => 'amount',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'created' => array('name' => 'created',
                         'type' => PUMPFORM_INT,
                         'title' => 'created',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'currency' => array('name' => 'currency',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'currency',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'interval_' => array('name' => 'interval_',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'interval_',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'interval_count' => array('name' => 'interval_count',
                         'type' => PUMPFORM_INT,
                         'title' => 'interval_count',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'livemode' => array('name' => 'livemode',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'livemode',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'metadata' => array('name' => 'metadata',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'metadata',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'name' => array('name' => 'name',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'name',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'statement_descriptor' => array('name' => 'statement_descriptor',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'statement_descriptor',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'trial_period_days' => array('name' => 'trial_period_days',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'trial_period_days',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        ),
);
