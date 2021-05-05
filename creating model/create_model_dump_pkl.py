from model_from_csv import RecommendModel
import pickle

model = RecommendModel()

print(type(model))

with open('saved_model.pkl', 'wb') as saved_model:
    pickle.dump(model, saved_model, pickle.HIGHEST_PROTOCOL)

with open('saved_model.pkl', 'rb') as saved_model:
    loaded_model = pickle.load(saved_model)