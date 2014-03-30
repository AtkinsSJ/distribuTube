from flask import Flask, render_template, url_for
app = Flask(__name__)

@app.route("/")
def hello():
	return "Hello, world!"

@app.route("/watch/<video_slug>")
def watch(video_slug):
	scripts = ["//vjs.zencdn.net/4.2/video.js"]
	stylesheets = ["//vjs.zencdn.net/4.2/video-js.css"]
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
		scripts=scripts,
		stylesheets=stylesheets,
		video=video
	)

if __name__ == "__main__":
	app.run(debug=True)