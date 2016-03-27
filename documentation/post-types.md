# Post Type Architecture And Hierarchy

## Hierarchy

The post types are set up with an intrinsic hierarchy which we have found to be the most useful when building with learning management systems. The structure flows something like this...

* Class
    * Lesson
        * Topic
            * Assignment
                * Certificate

So, a "Class" is the main container for content. In each "Class", there can be any number of "Lessons". A "Lesson" can contain any number of "Topics". "Topics" can have 'homework' or "Assignments". And once everything for a particular "Class" has been completed the student can then earn the "Certificate"; stating they have completed everything.

Of course, all these slugs can be changed and new post types can be inserted at any hierarchal level. To create new Hackademics post types or to change the slug of the pre-configured post types, go to *Hackademics->Settings* and choose the corresponding tab for the post type you'd like to configure; or the *New Post Type* tab to create a brand new post type. 
