<?php
 /* Template Name: form */

get_header();


?>
<form id="contact"  method="post" enctype="multipart/form-data" >
    <H3>Add ads</H3>
    <div id="note"></div>
    <div id="fields">
        <p>
            <input type="text" name="title" id="title" placeholder="Title" required>
            <label for="title">Title</label>
        </p>
        <p>
            <input type="file" name="image" id="image" required >
            <label for="image">Image</label>
        </p>
        <p>
            <input type="text" name="price" id="price" placeholder="Price" required>
            <label for="price">Price</label>
        </p>
        <p>
            <input type="text" name="name" id="name" placeholder="Name" required>
            <label for="name">Name</label>
        </p>
        <p>
            <input type="email" name="email" id="email" placeholder="E-mail" required>
            <label for="email">E-mail</label>
        </p>
        <p>
            <textarea rows="10" cols="45" name="textarea" id="textarea" required></textarea>
            <label for="textarea">About</label>
        </p>
        <p>
            <button type="submit" id="my_submit" class="go">Submit</button>
        </p>
    </div>
    <div id="loader"><div>
    <div id="submit-ajax"></div>
</form>


<?php

get_footer();
