<?php
/**
 *packet.php
 */
class zkPacket {
	private $m_packetBuffer;
	private $m_packetSize;

	public function __construct(){
		$this->m_packetSize = 0;
		$this->m_packetBuffer = "";
	}

	public function WriteBegin($xid, $opcode){
		/*
		type requestHeader struct {
			Xid    int32
			Opcode int32
		}
		*/
        $this->WriteInt($xid);
        $this->WriteInt($opcode);
	}

	public function WriteEnd(){
        $content ="";
		$content .= pack("N", $this->m_packetSize);			//len
		$content .= $this->m_packetBuffer;
		$this->m_packetBuffer	=	$content;
	}

	public function GetPacketBuffer(){
		return $this->m_packetBuffer;
	}

	public function GetPacketSize(){
		return $this->m_packetSize + 4;
	}

	public function WriteInt($value){
		$this->m_packetBuffer .= pack("N", $value);
		$this->m_packetSize += 4;
	}

	public function WriteInt64($value){
		$high   = intval($value / (1<<32));
		$low    = $value & ((1<<32)-1);
		$this->m_packetBuffer .= pack("N", $high);
		$this->m_packetBuffer .= pack("N", $low);
		$this->m_packetSize += 8;
	}

	public function WriteByte($value){
		$this->m_packetBuffer .= pack("C", $value);
		$this->m_packetSize += 1;
	}

	public function WriteShort($value){
		$this->m_packetBuffer .= pack("n", $value);
		$this->m_packetSize += 2;
	}

	public function WriteString($value){
		$len = strlen($value);
		$this->m_packetBuffer .= pack("N", $len);
		$this->m_packetBuffer .= $value;
		$this->m_packetSize += $len+4;
	}

	public function ParsePacket(){
		/*
		type responseHeader struct {
		Xid  int32
		Zxid int64
		Err  ErrCode
		}*/
		$xid =$this->ReadInt();
		$zxid =$this->ReadInt64();
		$err =$this->ReadErrCode();
		return ['xid'=>$xid,'zxid'=>$zxid,'err'=>$err];
	}

	public function SetRecvPacketBuffer($packet_buff, $packet_size){
		$this->m_packetBuffer = $packet_buff;
		$this->m_packetSize  = $packet_size;
	}

	public function ReadInt(){
		$temp = substr($this->m_packetBuffer, 0, 4);
		$value = unpack("N", $temp);
		$this->m_packetBuffer = substr($this->m_packetBuffer, 4);
		return $value[1];
	}

	public function ReadErrCode(){
		$temp = substr($this->m_packetBuffer, 0, 4);
		$value = unpack("s", $temp);
		$this->m_packetBuffer = substr($this->m_packetBuffer, 4);
		return $value[1];
	}


	public function ReadInt64(){
		$high = self::ReadInt();
		$low = self::ReadInt();
		return $high<<32 | $low;
	}
	
	public function ReadShort(){
		$temp = substr($this->m_packetBuffer, 0, 2);
		$value = unpack("n", $temp);
		$this->m_packetBuffer = substr($this->m_packetBuffer, 2);
		return $value[1];
	}

	public function ReadString(){
		$len = $this->ReadInt();
		$value = substr($this->m_packetBuffer, 0, $len);
		$this->m_packetBuffer = substr($this->m_packetBuffer, $len);
		return $value;
	}

	public function ReadByte(){
		$temp = substr($this->m_packetBuffer, 0, 1);
		$value = unpack("C", $temp);
		$this->m_packetBuffer = substr($this->m_packetBuffer, 1);
		return $value[1];
	}

}
