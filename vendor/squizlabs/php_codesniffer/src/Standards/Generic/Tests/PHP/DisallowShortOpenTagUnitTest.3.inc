// Test warning for when short_open_tag is off.

Some content <?php echo $var; ?> Some more content

// Test multi-line.
Some content <?php
echo $var;
?> Some more content

// Make sure skipping works.
Some content <?php
echo '<?';
?> Some more content

// Only recognize closing tag after opener.
Some?> content <?php
