# php-dvr
PHP Digital Video Recorder

# hardware
* <a href="https://www.amazon.com/SiliconDust-HDHR5-4US-HDHomeRun-Connect-4-Tuner/dp/B078LH47CD">hdhomerun quatro 4x tuner</a> (for atsc)
* hdmi network stream encoder (for cable tv)
* <a href="https://github.com/hackwin/esp8266InfraredRemoteRepeater">esp8266 pair for re-transmitting the IR remote signal</a>

# software
1. The program zap2xml is scheduled to download XML electronic programming guides (EPG) every day.  It fetches two days worth of data at a time.
2. The video gets recorded using Task Scheduler which runs a php script that runs ffmpeg.
3. PHP refers to the XML EPG to get the correct program and episode information to be used for Folder and File names.
4. The cable TV tuner current channel is stored in a text file on a web server.  Channels are changed through a web interface which logs the channel changed.
