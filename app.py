from flask import Flask
app = Flask(__name__)

@app.route('/index.html')
def index.html():
    return 'Hello, World!'
