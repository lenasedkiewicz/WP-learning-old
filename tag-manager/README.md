# Marketing Tag Manager by MSedkiewicz

Simple WP plugin for adding script tags to custom post type. Plugin does not require additional libraries / plugins for deployment.

# For developers

## Approach

Main objective while writing this plugin was to separate admin environment (for adding / editing tag) and other users environment for adding tag to posts / pages.

## What was achieved
1. Plugin code is executed in footer
2. Options page that allow to add plugin is available only for admin
3. Custom post types allow to edit / delete created tag, so when problem 1 from further improvements will be solved this functionality would be visible.

## Further improvements

1. Saving tags in custom post type (probably it would be more beneficial to keep whole logic in custom post type and play with current_user_can() function more - https://developer.wordpress.org/reference/functions/current_user_can/)
2. Add logic for chosing which posts / pages should display chosen tags (https://developer.wordpress.org/plugins/metadata/custom-meta-boxes/)
3. Add sanitization (for security reasons; this would require research on most popular tags syntax and maybe additional field for admin to add new syntax to allowed list)
4. Allow using <script> tag in content (currently script tag is added in plugin and this may cause some issues in case ie. of Google analytics - if user chooses to add GA tag in footer, despite recommendations, it would require adding 2 tags and making sure they fire in proper order)
5. It would be beneficial to check how many database queries are made in this approach to see, how plugin may slow down the page and how many tags can appear on a page without deteriorating page speed; I'd suggest tests involving GTM placed tags vs. plugin placed tags and writing recommendations / doing further improvements based on this knowledge.
6. Some architecture solutions were tested here: https://github.com/msedkiewicz/test. For decent functioning plugin architecture should be improved based on acquired knowledge.
