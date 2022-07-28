# README

# Contents

- Introduction
- Prerequisites
- Rebranding
- Installing the payment module
- License

# Introduction

This X-Cart module provides an easy method to integrate with the payment gateway.
 - The httpdocs directory contains the files that need to be uploaded to the root of your X-Cart installation
 - Supports X-Cart versions: **5.3+**

# Prerequisites

- The module requires the following prerequisites to be met in order to function correctly:
    - The 'bcmath' php extension module: https://www.php.net/manual/en/book.bc.php

> Please note that we can only offer support for the module itself. While every effort has been made to ensure the payment module is complete and bug free, we cannot guarantee normal functionality if unsupported changes are made.

# Rebranding

To rebrand this module, complete the following steps:

1.In file `httpdocs/classes/XLite/Module/PaymentNetwork/Model/Payment/Processor/PaymentNetwork.php` change the following:
	- Line 4: `* Copyright (c) 2016-present PaymentNetwork. All rights reserved.` change the copyright to your brand name
	- Line 17: `const GATEWAYURL = "https://commerce-api.handpoint.com/hosted/";` change the URL to that which we supply

2. In file `httpdocs/classes/XLite/Module/PaymentNetwork/PaymentNetwork/Main.php` change the following:
	- Line 23: ` * @author    PaymentNetwork Ltd <support@example.com>` change to your brand and support email
	- Line 24: ` * @copyright Copyright (c) 2016-present PaymentNetwork Ltd <support@example.com>. All rights reserved` change to your brand and support email

	- Line 39: `    return 'PaymentNetwork';` change PaymentNetwork to your brand name
	- Line 48: `    return 'PaymentNetwork Hosted';` change PaymentNetwork to your brand name
	- Line 75-76: `    return 'Adds the ability to take card payments for your online store '
           'via PaymentNetwork Hosted Payment Gateway.';` change PaymentNetwork to your brand name
	
3. In file `httpdocs/classes/XLite/Module/PaymentNetwork/PaymentNetwork/install.yaml` change the following:
	- Line 7: `        name: PaymentNetwork` change PaymentNetwork to your brand name
	- Line 14: `        value: https://commerce-api.handpoint.com/hosted/` change the URL to that which we supply

4. Finally replace the files:
	- `httpdocs/classes/XLite/Module/PaymentNetwork/PaymentNetwork/icon.png` and
	- `httpdocs/skins/admin/modules/PaymentNetwork/PaymentNetwork/method_icon.png` with your own brand logos
	
5. When downloading as a zip file, you can right-click and rename to remove the `Unbranded` text from the filename

# Installing and configuring the module

1. Copy and paste the contents of httpdocs to your root X-Cart
2. Log in to your admin panel and navigate to System Settings -> Cache Management and click 'redeploy store'
3. Navigate to modules and locate PaymentNetwork and click the 'install' button, the store will redeploy again automatically
4. Click 'settings' under the PaymentNetwork module you just installed
5. Under Online Payments click 'Add Payment Method'. Locate and add PaymentNetwork
6. Configure the PaymentNetwork payment gateway and save. Now you should be able to see and checkout using the PaymentNetwork payment gateway

License
----
MIT
