# Test plugin

Test plugin created for testing a different approach to coding that the one taken in the following project: https://github.com/msedkiewicz/tag-manager .

## Requirements

For setting privileges for users it is required to install Members plugin by MemberPress https://wordpress.org/plugins/members/. Administrator can set privileges for tag adding and editing for WordPress users.

# For developers

## Approach

Main objective while writing this plugin was to simplify UX by keeping tag adding in custom post types.
Adding tags to post / page in first approach was based on metabox list allowing to add / substract posts and pages from the list. This solution would require improvement in work of metabox.
Second approach was to use native WordPress tags for posts and for custom post type JS tags for displaying JS tags. In this approach I tried to "connect" posts and custom post type JS tags by comparing associated tags. Third approach was a bit different and required setting new type of tags that will be associated only with custom post type JS tags and compare tags added to CPT with tags added to post. This aproach, however, cannot be used for pages.

## What was achieved
1. Proper priviledge settings for WordPress native users
2. Tested metabox approach (should be more useful than tag approach)
3. Code executes

## Further improvements
1. WordPress required information should be added
2. Code should be set in footer (this requires checking why wp_footer action is not working)
3. Code should execute only if some conditions are met, not when any tags are added
4. Plugin needs significant code refactoring including
 - separating code in different files
 - adding security layer
 - unifying naming convention for functions / tags etc.
 as it is done here: https://github.com/msedkiewicz/tag-manager/tree/main
