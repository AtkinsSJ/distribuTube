from flask import Flask, render_template
app = Flask(__name__)

@app.route("/")
def hello():
	return "Hello, world!"

@app.route("/watch/<video_slug>")
def watch(video_slug):
	return render_template("watch.html", video_name=video_slug, scripts=["//vjs.zencdn.net/4.2/video.js"])

if __name__ == "__main__":
	app.run(debug=True)