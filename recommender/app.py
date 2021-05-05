from flask import Flask, render_template, url_for
from flask_mysqldb import MySQL
import pickle
import yaml

# Read model      
def output_recommendations(book_name):     
    with open('saved_model.pkl', 'rb') as saved_model:
        loaded_model = pickle.load(saved_model)

    book_list = loaded_model.corpus_recommendations(book_name)
    return book_list

# Get details of recommended books
def get_details(book_list):
    img_list = {}
    cur = mysql.connection.cursor()

    for book in book_list:
        resultValue = cur.execute("SELECT image_url FROM books WHERE title = %s LIMIT 1", (book,))
        if resultValue > 0:
            img = str(cur.fetchall())
            img_list[book] = img[3:-5]
        else:
            img_list[book] = None
    return img_list

app = Flask(__name__)
db = yaml.load(open('db.yaml'))

# Configure DB
app.config['MYSQL_HOST'] = db['mysql_host']
app.config['MYSQL_USER'] = db['mysql_user']
app.config['MYSQL_PASSWORD'] = db['mysql_password']
app.config['MYSQL_DB'] = db['mysql_db']
app.config['MYSQL_PORT'] = db['mysql_port']

mysql = MySQL(app)

@app.route('/')
@app.route('/books')
def books():
    cur = mysql.connection.cursor()
    resultValue = cur.execute("SELECT * FROM books")
    if resultValue > 0:
        books = cur.fetchall()
        return render_template('testbooks.html', books = books)


@app.route('/book_details/<book_title>')
def book_details(book_title):
    cur = mysql.connection.cursor()
    resultValue = cur.execute("SELECT * FROM books WHERE title = %s LIMIT 1", (book_title,))
    if resultValue > 0:
        rec_book_list = output_recommendations(book_title)
        book = cur.fetchall()
        recom_books_details = get_details(rec_book_list)
        return render_template('book_details.html', book = book, book_dict = recom_books_details)
    return 'No book'

if __name__ == '__main__':
    app.run(debug=True)