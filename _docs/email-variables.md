---
title: Email variables
---

## Pseudo-variable

Simple text substitution for pseudo-variables contained within your HTML files. It can parse simple variables or variable tag pairs.

Pseudo-variable names are enclosed in braces, like this:

```html
<html>
  <head>
    <title>{blog_title}</title>
  </head>
  <body>
    <h3>{blog_heading}</h3>

  {blog_entries}
    <h5>{title}</h5>
    <p>{body}</p>
  {/blog_entries}

  </body>
</html>
```

## Variable Pairs
The above example code allows simple variables to be replaced. What if you would like an entire block of variables to be repeated, with each iteration containing new values?

```html
<html>
  <head>
    <title>{blog_title}</title>
  </head>
  <body>
    <h3>{blog_heading}</h3>

  {blog_entries}
    <h5>{title}</h5>
    <p>{body}</p>
  {/blog_entries}

  </body>
</html>
```
In the above code you’ll notice a pair of variables: `{blog_entries} data... {/blog_entries}`. In a case like this, the entire chunk of data between these pairs would be repeated multiple times, corresponding to the number of rows in the “blog_entries” element of the parameters array.

Parsing variable pairs is done using the identical code shown above to parse single variables, except, you will add a multi-dimensional array corresponding to your variable pair data. Consider this example

```
data[blog_title]=My Blog Title&\
data[blog_heading]=My Blog Heading&\
data[blog_entries][title]=Title 1&\
data[blog_entries][body]=Body 1&\
data[blog_entries][title]=Title 2&\
data[blog_entries][body]=Body 2&\
data[blog_entries][title]=Title 3&\
data[blog_entries][body]=Body 3&\
data[blog_entries][title]=Title 4&\
data[blog_entries][body]=Body 4&\
data[blog_entries][title]=Title 5&\
data[blog_entries][body]=Body 5
```

## Usage Notes
If you include substitution parameters that are not referenced in your template, they are ignored:
```
data[title]=Mr&\
data[firstname]=John&\
data[lastname]=Doe

// Hello, {firstname} {lastname}
// Result: Hello, John Doe
```

If you do not include a substitution parameter that is referenced in your template, the original pseudo-variable is shown in the result:
```
data[title]=Mr&\
data[firstname]=John&\
data[lastname]=Doe

// Hello, {firstname} {initials} {lastname}
// Result: Hello, John {initials} Doe
```

If you provide a string substitution parameter when an array is expected, i.e. for a variable pair, the substitution is done for the opening variable pair tag, but the closing variable pair tag is not rendered properly:
```
data[degree]=Mr&\
data[firstname]=John&\
data[lastname]=Doe&\
data[degrees][degree]=BSc&\
data[degrees][degree]=PhD

// Hello, {firstname} {lastname} ({degrees}{degree} {/degrees})
// // Result: Hello, John Doe (Mr{degree} {/degrees})
```

If you name one of your individual substitution parameters the same as one used inside a variable pair, the results may not be as expected:
```
data[degree]=Mr&\
data[firstname]=John&\
data[lastname]=Doe&\
data[degrees][degree]=BSc&\
data[degrees][degree]=PhD

// Hello, {firstname} {lastname} ({degrees}{degree} {/degrees})
// Result: Hello, John Doe (Mr Mr )
```

## Reserved Pseudo-variables
Vars | Description | Example
--- | --- | ---
`_request_id` | | |
`_subject` | | |
`_list_recipient_id` | | |
`_to_email` | | |
`_to_name` | | |
`_reply_to_email` | | |
`_reply_to_name` | | |
`_unsubscribe_link` | Unsubscribe link | |
`_web_version_link` | Web version link | *https&#58;&#47;&#47;s3.amazonaws.com&#47;bucket&#47;requests&#47;7-8f14e45fceea167a5a36dedd4bea25430fda77af5ec567e2351ce16a0b9958f7.html\|txt* |
`_current_day` | A full textual representation of the day of the week | *Sunday* through *Saturday* |
`_current_day_number` | Numeric representation of the day of the week | *1* (for Monday) through *7* (for Sunday) |
`_current_date` | Day of the month | *1* to *31* |
`_current_month` | Full textual representation of the month | *January* through *December* |
`_current_month_number` | Numerical representation of the month | *1* through *12* |
`_current_year` | Full numeric representation of the year, 4 digits |  *1999* or *2003* |
`_campaign_archive_link` | Only for campaign mails | |
`_app_name` | | |
`_app_base_url` | | |