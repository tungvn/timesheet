# Authoring Features

This directory contains reusable authoring tools such as content creators.

# Author Usage

## Has Authors Trait

Once the database columns added, you can use the `App\Timesheets\Authoring\HasAuthors` trait on your model.
This trait will be in charge of listening to the creating and updating events on the model and update 
the columns accordingly based on the `auth()->user()` information.

This trait contains the following functions:

* Boots the author observer
* Create a belongs to many relationship with the `App\User` for the author
* Create a belongs to many relationship with the `App\User` for the updater
* Provide a query scope to see the owner of the entity
* Provide a helper method to check if the author of the entity is a given user

## Authors and Policies

The trait will give you access to a helper function which will allow you do check if the author of the
entity is the authenticated user. This is useful when writing Laravel Policies.

e.g. `$model->authorIs($user)`
