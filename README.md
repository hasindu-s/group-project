# Introduction

This is a web based book recommendation system I have developed as a part of one of my university projects.

  ## Used data and technologies

  * Dataset - Goodreads 10K dataset
  * Python web framework = Flask
  * Database - MySQL (Runs on port 3307)
  * Virtual servers - Flask server for displaying recommendations and XAMPP for displaying product listing page
  * Create a file from the model - Pickle (This allows to save the model as an object and get recommendations quickly)
  
  Recommendation is done by finding books with similar corpus to a given book and displaying top 10 (number of recommendations can be changed) books with the least distance (distance is measured by cosine similarity).
  
This project includes a product listing page with pagination.
