import pickle

# with open('saved_model.pkl', 'rb') as saved_model:
#     loaded_model = pickle.load(saved_model)

def loop_questions():
    for i in range(3):
        book_name = input("Enter book name: ")
        print("Recommendations for", book_name)
        book_list = loaded_model.corpus_recommendations(book_name)

        for book in book_list:
            print(book)

def output_recommendations(book_name):
    with open('saved_model.pkl', 'rb') as saved_model:
        loaded_model = pickle.load(saved_model)
        
    book_list = loaded_model.corpus_recommendations(book_name)
    return book_list

#loop_questions()