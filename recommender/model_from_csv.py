import pandas as pd
import numpy as np
import os
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel

class RecommendModel:
    
    def __init__(self):
        #self.engine = create_engine('mysql+pymysql://root:12345@localhost/bookstore')

        self.ratings = pd.read_csv('./CSV/ratings.csv', encoding = "ISO-8859-1")
        self.books = pd.read_csv('./CSV/books.csv', encoding = "ISO-8859-1")
        self.tags = pd.read_csv('./CSV/tags.csv', encoding = "ISO-8859-1")
        self.to_read = pd.read_csv('./CSV/to_read.csv', encoding = "ISO-8859-1")
        self.book_tags = pd.read_csv('./CSV/book_tags.csv', encoding = "ISO-8859-1")

        #self.engine.dispose()

        self.tags_join_DF = pd.merge(self.book_tags, self.tags, left_on='tag_id', right_on='tag_id', how='inner')

        self.books_with_tags = pd.merge(self.books, self.tags_join_DF, left_on='book_id', right_on='goodreads_book_id', how='inner')

        self.temp_df = self.books_with_tags.groupby('book_id')['tag_name'].apply(' '.join).reset_index()

        self.books = pd.merge(self.books, self.temp_df, left_on='book_id', right_on='book_id', how='inner')

        self.books['corpus'] = (pd.Series(self.books[['authors', 'tag_name']]
                    .fillna('')
                    .values.tolist()
                    ).str.join(' '))
        
        self.indices1 = pd.Series(self.books.index, index=self.books['title'])

        self.tf_corpus = TfidfVectorizer(analyzer='word',ngram_range=(1, 2),min_df=0, stop_words='english')
        self.tfidf_matrix_corpus = self.tf_corpus.fit_transform(self.books['corpus'])
        self.cosine_sim_corpus = linear_kernel(self.tfidf_matrix_corpus, self.tfidf_matrix_corpus)

        self.titles = self.books['title']
        self.indices = pd.Series(self.books.index, index=self.books['title'])

    def corpus_recommendations(self, title):
        self.idx = self.indices1[title]
        self.sim_scores = list(enumerate(self.cosine_sim_corpus[self.idx]))
        self.sim_scores = sorted(self.sim_scores, key=lambda x: x[1], reverse=True)
        self.sim_scores = self.sim_scores[1:11]
        self.book_indices = [i[0] for i in self.sim_scores]
        return self.titles.iloc[self.book_indices]