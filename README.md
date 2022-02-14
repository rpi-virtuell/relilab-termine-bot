## relilab-termine-bot
## Wordpress Plugin to post a link to a post created via ACF Frontend Forms
### **_Note: This plugin requires ACF Pro and Frontend in order to work_*

**1. Installation**

This plugin can be download or routed directly to your WP Plugin page via link

***

**2. Importing Options**

In order to configure the plugin you need to import the option page and field groups via the Tool section of ACF Pro in your WP Backend
there are two JSON files in this repo which can be imported:

* **field-group-relilab-termine-bot-import.json**

Use the **Import Fieldgroup** function to import this **field-group** JSON properly
This JSON contains the fieldgroups used to save the information which is set by the option page

* **option-page-relilab-termine-bot-import.json**

Use the **Import Options Pages** function to import this **option-page** JSON propertly test
This JSON contains the information used to display the option page

***

**3. Option Page**

After importing both plugin and JSON files you should now see a new options page in your options section.
This Plugin gives you the following options to setup

* Termine Martix Bot Webhook Link

This field should contain the Webhook link to the Matrix/Chat Bot.
_Note: Since publishing this Webhook compromises the security of the chat the bot is used in, this field remains copy and read protected_


***

**4. Using the Plugin**

The Plugin will engage once a Post is created via ACF Frontend Form
_Note: This Plugin does not support Admin Approval as Post requirement_

