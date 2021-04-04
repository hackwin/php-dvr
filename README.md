# php-dvr
PHP Digital Video Recorder

# hardware
* hdhomerun quatro 4x tuner (for atsc)
* hdmi network stream encoder (for cable tv)
* esp8266 pair for re-transmitting the IR remote signal

# software
1. The program zap2xml is scheduled to download XML electronic programming guides (EPG) every day.  It fetches two days worth of data at a time.
2. The video gets recorded using Task Scheduler which runs a php script that runs ffmpeg.
3. PHP refers to the XML EPG to get the correct program and episode information to be used for Folder and File names.
