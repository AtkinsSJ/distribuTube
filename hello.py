from flask import Flask, render_template, url_for
from configparser import ConfigParser

app = Flask(__name__)
config = ConfigParser()
config.read("config.ini")
app.config.update(config["app"])

@app.route("/")
def hello():
	return "Hello, world!"

@app.route("/watch/<video_slug>")
def watch(video_slug):
	video = {
		"id": video_slug,
		"title": "Test Video",
		"poster": url_for("static", filename="videos/BeardSimPrototype.jpg"),
		"sources": {
			"mp4": url_for("static", filename="videos/BeardSimPrototype.mp4"),
			"ogg": url_for("static", filename="videos/BeardSimPrototype.ogv"),
			"webm": url_for("static", filename="videos/BeardSimPrototype.webm")
		}
	}
	return render_template(
		"watch.html",
		video=video
	)

if __name__ == "__main__":
	app.run(host="0.0.0.0")