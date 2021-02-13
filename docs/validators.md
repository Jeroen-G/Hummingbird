# Validators and assertions

Shortcut assertion  | Validator
---                 | ---
h1                  | Allow only one H1
og                  | Required set of Open Graph meta tags
title               | There must be a title tag and it must be no longer than 55 characters
alt                 | All images must have an alt tag
lang                | The HTML opening tag should have a valid lang attribute
vp                  | There should be a viewport meta tag with width and initial-scale set
atxt                | Links should have a descriptive text
auvid               | No autoplaying videos, they bad for accessibility reasons and *really* annoying
mdesc               | There should be a description meta tag with content between 50 and 160 characters
canon               | It is a good practice to have a canonical link on your pages

If you have an idea for a new validator, be sure to open an issue!
