import { useState, useRef } from "react";
import { Mic, Video, Square, Play, RotateCcw, Send, Loader2, Type } from "lucide-react";

const C = {
  navy: "#0B2E35",
  teal: "#0F6E6B",
  coral: "#F2453F",
  green: "#17D67D",
  ink: "#0B2545",
};

/**
 * Recorder — lets a student answer by typing, recording audio, or recording video.
 * Calls onSubmit({ answerType, text, blob, durationSeconds }) when the student submits.
 */
export default function Recorder({ onSubmit, submitting }) {
  const [mode, setMode] = useState("text"); // text | audio | video
  const [recording, setRecording] = useState(false);
  const [blobUrl, setBlobUrl] = useState(null);
  const [recordedBlob, setRecordedBlob] = useState(null);
  const [seconds, setSeconds] = useState(0);
  const [text, setText] = useState("");
  const [error, setError] = useState(null);

  const mediaRecorderRef = useRef(null);
  const chunksRef = useRef([]);
  const streamRef = useRef(null);
  const timerRef = useRef(null);
  const videoPreviewRef = useRef(null);

  function resetRecording() {
    setBlobUrl(null);
    setRecordedBlob(null);
    setSeconds(0);
    setError(null);
  }

  async function startRecording() {
    resetRecording();
    setError(null);
    try {
      const constraints = mode === "video" ? { audio: true, video: true } : { audio: true };
      const stream = await navigator.mediaDevices.getUserMedia(constraints);
      streamRef.current = stream;

      if (mode === "video" && videoPreviewRef.current) {
        videoPreviewRef.current.srcObject = stream;
        videoPreviewRef.current.muted = true;
        videoPreviewRef.current.play();
      }

      const mimeType = mode === "video" ? "video/webm" : "audio/webm";
      const recorder = new MediaRecorder(stream, { mimeType });
      chunksRef.current = [];

      recorder.ondataavailable = (e) => {
        if (e.data.size > 0) chunksRef.current.push(e.data);
      };

      recorder.onstop = () => {
        const blob = new Blob(chunksRef.current, { type: mimeType });
        setRecordedBlob(blob);
        setBlobUrl(URL.createObjectURL(blob));
        streamRef.current?.getTracks().forEach((t) => t.stop());
      };

      recorder.start();
      mediaRecorderRef.current = recorder;
      setRecording(true);
      setSeconds(0);
      timerRef.current = setInterval(() => setSeconds((s) => s + 1), 1000);
    } catch (e) {
      setError("Could not access microphone/camera. Please allow permission and try again.");
    }
  }

  function stopRecording() {
    mediaRecorderRef.current?.stop();
    clearInterval(timerRef.current);
    setRecording(false);
  }

  function switchMode(newMode) {
    if (recording) stopRecording();
    resetRecording();
    setText("");
    setMode(newMode);
  }

  function handleSubmit() {
    if (mode === "text") {
      if (!text.trim()) return;
      onSubmit({ answerType: "text", text, durationSeconds: 0 });
    } else {
      if (!recordedBlob) return;
      onSubmit({ answerType: mode, blob: recordedBlob, durationSeconds: seconds });
    }
  }

  const modes = [
    { key: "text", label: "Type", icon: Type },
    { key: "audio", label: "Audio", icon: Mic },
    { key: "video", label: "Video", icon: Video },
  ];

  return (
    <div>
      {/* Mode switcher */}
      <div className="mb-5 flex gap-2">
        {modes.map((m) => (
          <button
            key={m.key}
            onClick={() => switchMode(m.key)}
            disabled={submitting}
            className="flex flex-1 items-center justify-center gap-1.5 rounded-xl py-2.5 text-sm font-bold transition"
            style={{
              backgroundColor: mode === m.key ? C.teal : "#EAF1F8",
              color: mode === m.key ? "white" : C.ink,
            }}
          >
            <m.icon size={16} /> {m.label}
          </button>
        ))}
      </div>

      {/* TEXT MODE */}
      {mode === "text" && (
        <textarea
          value={text}
          onChange={(e) => setText(e.target.value)}
          placeholder="Type your answer as if you were saying it out loud…"
          rows={6}
          disabled={submitting}
          className="w-full resize-none rounded-2xl border-2 p-4 text-base outline-none"
          style={{ borderColor: "#EAF1F8", color: C.ink }}
        />
      )}

      {/* AUDIO / VIDEO MODE */}
      {(mode === "audio" || mode === "video") && (
        <div className="flex flex-col items-center rounded-2xl p-6" style={{ backgroundColor: "#F7FAFD" }}>
          {mode === "video" && (
            <video
              ref={videoPreviewRef}
              className="mb-4 w-full max-w-xs rounded-xl bg-black"
              style={{ display: recording ? "block" : blobUrl ? "none" : "block", aspectRatio: "4/3" }}
            />
          )}

          {blobUrl && !recording && (
            mode === "video" ? (
              <video src={blobUrl} controls className="mb-4 w-full max-w-xs rounded-xl" />
            ) : (
              <audio src={blobUrl} controls className="mb-4 w-full" />
            )
          )}

          {!blobUrl && !recording && (
            <button
              onClick={startRecording}
              disabled={submitting}
              className="flex h-16 w-16 items-center justify-center rounded-full text-white shadow-lg transition hover:opacity-90"
              style={{ backgroundColor: C.coral }}
            >
              {mode === "video" ? <Video size={26} /> : <Mic size={26} />}
            </button>
          )}

          {recording && (
            <button
              onClick={stopRecording}
              className="flex h-16 w-16 items-center justify-center rounded-full text-white shadow-lg animate-pulse"
              style={{ backgroundColor: C.coral }}
            >
              <Square size={22} fill="white" />
            </button>
          )}

          <p className="mt-3 text-sm font-semibold" style={{ color: `${C.ink}99` }}>
            {recording ? `Recording… ${seconds}s` : blobUrl ? `Recorded ${seconds}s — review above` : "Tap to start recording"}
          </p>

          {blobUrl && !recording && (
            <button
              onClick={resetRecording}
              disabled={submitting}
              className="mt-3 flex items-center gap-1.5 text-sm font-bold"
              style={{ color: C.teal }}
            >
              <RotateCcw size={14} /> Record again
            </button>
          )}

          {error && <p className="mt-3 text-sm font-semibold text-red-500">{error}</p>}
        </div>
      )}

      <button
        onClick={handleSubmit}
        disabled={
          submitting ||
          (mode === "text" && !text.trim()) ||
          ((mode === "audio" || mode === "video") && !recordedBlob)
        }
        className="mt-5 flex w-full items-center justify-center gap-2 rounded-full py-3.5 text-base font-bold text-white transition disabled:opacity-40"
        style={{ backgroundColor: C.teal }}
      >
        {submitting ? (
          <>
            <Loader2 size={18} className="animate-spin" /> Submitting…
          </>
        ) : (
          <>
            Submit Answer <Send size={16} />
          </>
        )}
      </button>
    </div>
  );
}