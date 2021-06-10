
const siswa = [
    {'id':1, 'name':'elo'},
    {'id':2, 'name':'alo'},
  ];
  //tutor
  const tutor = [
    {'id':1, 'name':'pak eko'},
    //{'id':2, 'name':'buk eka'},
  ];
  //kelas
  const kelas = [
    {'id':1,'name':'Kelas hola','pertemuan':4},
    {'id':2,'name':'Kelas hae','pertemuan':10},
  ] ;
  //jadwal siswa
  const jadwal = [
    {'id':1,'id_kelas':1,'siswa':1,'tutor':1,'tanggal':'2021-03-17','jam':'07:00'},
    {'id':2,'id_kelas':1,'siswa':1,'tutor':1,'tanggal':'2021-03-18','jam':'07:00'},
    {'id':3,'id_kelas':1,'siswa':1,'tutor':1,'tanggal':'2021-03-24','jam':'07:00'},
    {'id':4,'id_kelas':1,'siswa':1,'tutor':1,'tanggal':'2021-03-25','jam':'07:00'},
  ];
  

  
  function make_schedule(meet_total,kelas,tutor, meetweek, date , hours){
      var a = meet_total%meetweek;
      var c = meet_total % meetweek==0?meet_total/meetweek:(meet_total-(meet_total%meetweek))/meetweek;
      var jadwal_siswa = [];
      var date_increament = 0;
      //keep it up sware -3-
      //jadwal maker
      for(var i=0;i < c;i++){
        for(var j=0;j < date.length;j++){
          var tmp_date = new Date(new Date(date[j]).setDate(new Date(date[j]).getDate()+date_increament));
          var tmp_jadwal = tmp_date.getFullYear()+'-'+String(tmp_date.getMonth()+1).padStart(2,'0')+'-'+String(tmp_date.getDate()).padStart(2,'0');
          jadwal_siswa.push(
            {'tanggal':tmp_jadwal,'jam':hours[j]}
            );
        }
        date_increament += 7;
      }
      if(a!=0){
        for(var j=0;j < a;j++){
          var tmp_date = new Date(new Date(date[j]).setDate(new Date(date[j]).getDate()+date_increament));
          var tmp_jadwal = tmp_date.getFullYear()+'-'+String(tmp_date.getMonth()+1).padStart(2,'0')+'-'+String(tmp_date.getDate()).padStart(2,'0');
          jadwal_siswa.push(
            {'tanggal':tmp_jadwal,'jam':hours[j]}
          );
          date_increament+=7;
        }
      }
      //rest jadwal


      //tmp tanggal jadwal
      tmp_old_sch = [];
      tmp_new_sch =[];
      tmp_old_sch_hours = [];
      tmp_new_sch_hours =[];
      jadwal_siswa.forEach(ele=>tmp_new_sch.push(ele.tanggal));
      jadwal.forEach(ele=>tmp_old_sch.push(ele.tanggal));
      jadwal_siswa.forEach(ele=>tmp_new_sch_hours.push(ele.jam));
      jadwal.forEach(ele=>tmp_old_sch_hours.push(ele.jam));
      //jadwal checker 
      check_jadwal = tmp_new_sch.findIndex(new_sch => 
        tmp_old_sch.some((old_sch)=>new_sch == old_sch)
      );
      check_jam = tmp_new_sch_hours.findIndex(new_sch => 
        tmp_old_sch_hours.some((old_sch)=>new_sch == old_sch)
      )
      //cek jadwal tutor berdasarkan tanggal
      //nilai lebih dari 0 = index jadwal yg tidak kosong
      //
      var report = check_jadwal < 0?jadwal_siswa:check_jadwal;
      
      console.log(report);
      console.log(check_jam);
  };

 //make_schedule(11,1,1, 2, ['2021-03-18','2021-03-20'] , ['07:00','07:00']);
