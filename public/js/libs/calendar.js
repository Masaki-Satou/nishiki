class Calender{
    // sHolidays=['2024/08/12','2022/09/19','2022/09/23','2022/10/10','2022/11/03','2022/11/23','2023/01/02','2023/01/09','2023/02/11','2023/02/23','2023/03/21','2023/04/29','2023/05/03','2023/05/04','2023/05/05'];
    week = ["日", "月", "火", "水", "木", "金", "土"];
    today=new Date();//本日
    constructor(wrapClass,add_number){
        this.wrapClass=wrapClass;
        this.showDate=new Date(this.today.getFullYear(),this.today.getMonth()+add_number,1);//その月の1日
        
        if(this.preEl=document.querySelector(this.wrapClass + ' .prev')){
            this.preEl.addEventListener('click',this.prev.bind(this));
        };

        if(this.nextEl=document.querySelector(this.wrapClass + ' .next')){
            this.nextEl.addEventListener('click',this.next.bind(this));
        };


        this.showProcess(this.showDate);
    }


    prev(){
        this.showDate.setMonth(this.showDate.getMonth() - 1);
        this.showProcess(this.showDate);

        if(parseInt(sessionStorage.getItem('month_add'))){
            sessionStorage.setItem('month_add',parseInt(sessionStorage.getItem('month_add'))-1)
        }else{
            sessionStorage.setItem('month_add',-1)
        }

    }

    next(){
        this.showDate.setMonth(this.showDate.getMonth() + 1);
        this.showProcess(this.showDate);

        if(parseInt(sessionStorage.getItem('month_add'))){
            sessionStorage.setItem('month_add',parseInt(sessionStorage.getItem('month_add'))+1)
        }else{
            sessionStorage.setItem('month_add',1)
        }

    }

    showProcess(date) {
        let year = date.getFullYear();
        let month = date.getMonth();//0～11で取得されるので、正しい月は+1する（setMonth())も同様で8月なら7で設定する
        
        document.querySelector(this.wrapClass + ' > .cheader').innerHTML = "【 " + year + "年 " + (month + 1) + "月 】";
        
        let calendar = this.createProcess(year, month);
        document.querySelector(this.wrapClass + ' > .calendar').innerHTML = calendar;
    }
    
    createProcess(year, month) {
        
        // 曜日
        let calendar = "<table><tr class='dayOfWeek'>";
        for (let i = 0; i < this.week.length; i++) {
            calendar += "<th class=''>" + this.week[i] + "</th>";
        }
        calendar += "</tr>";
    
        let count = 0;
        let startDayOfWeek = new Date(year, month, 1).getDay();//指定した年月の1日が何曜日か（日曜日が0～）

        let endDate = new Date(year, month + 1, 0).getDate();//第三引数が　0　の場合は※先月※の末日　month+1　しているので、設定月の末日となる
        let lastMonthEndDate = new Date(year, month, 0).getDate();//先月の末日
        let row = Math.ceil((startDayOfWeek + endDate) / this.week.length);//日付け部分の行数（切り上げ）
        
        // 1行ずつ設定
        for (let i = 0; i < row; i++) {
            calendar += "<tr>";
            // 1colum単位で設定
            for (let j = 0; j < this.week.length; j++) {
                if (i == 0 && j < startDayOfWeek) {
                    // 1行目で1日まで先月の日付を設定
                    calendar += "<td class='disabled'>" + (lastMonthEndDate - startDayOfWeek + j + 1) + "</td>";
                } else if (count >= endDate) {
                    // 最終行で最終日以降、翌月の日付を設定
                    count++;
                    calendar += "<td class='disabled'>" + (count - endDate) + "</td>";
                } else {
                    let my_today=0;//本日かどうかのflag
                    let itti=0//sHolidayと一致するかのflag
                    // 当月の日付を曜日に照らし合わせて設定
                    count++;
                    let my_day= new Date(year,month,count);//走査する日付け
                    let no_time_today=new Date(this.today.getFullYear(),this.today.getMonth(),this.today.getDate());//本日の日付け（時間を省く）

                    if(no_time_today.getTime()==my_day.getTime()){
                        // alert(no_time_today.getTime());
                        my_today=1
                    }
                    
                    if(my_day.getTime() < no_time_today.getTime()){
                        calendar += "<td class='disabled'>" + count + "</td>";//過去の日付けはdisableクラスを付与
                    }else{

                        // let my_day=new Date(year,month,count);
                        let my_month=month<9 ? `0${1+month}` : `${1+month}` ;//1なら01に
                        let my_count= count<10 ? `0${count}` : `${count}`;//上と同様
                        

                        //sHolidaysと一致するか調べる
                        if(typeof this.sHolidays !== 'undefined'){
                            for(let v of this.sHolidays){
        
                                let my_day2=new Date(v);
        
                                if(my_day2>my_day){//この時点でのsHolidaysの値がこの時点での日より大きくなった時点で抜ける
                                    break;
                                }

                                if(my_day.getTime() == my_day2.getTime()){
        
                                    if(my_today){
                                        calendar += "<td class='today holiday'><a href='/reserved_edit/" + year + "-" + my_month + "-" + my_count +"'>" + count + "</a></td>";//sHolidaysと本日両方と一致
                                    }else{
                                        calendar += "<td class='holiday'><a href='/reserve_edit/" + year + "-" + my_month + "-" + my_count +"'>" + count + "</a></td>";//sHolidaysのみと一致
                                    }
                                    itti=1;
                                    break;
                                }
                            }
                        }
                        
                        //sHolidaysと一致しなかった場合
                        if(itti==0){
                            if(my_today){//本日の日付け
                                calendar += "<td class='today disabled'>" + count + " </td>";
                            }else{

                                let itti2=0;
                                let pri=0;

                               for(let i=0; i < reserveds.length; i++){
                                  if((year + "-" + my_month + "-" + my_count)==reserveds[i].reserved_at){
                                        itti2=1;//誰かに予約されている
                                        if(user_id== reserveds[i].user_id){
                                            itti2+=1;//自分が予約している
                                        }
                                        break;
                                  } 
                               }

                               for(let i=0; i < priorities.length; i++){
                                    if(count==priorities[i].priority_day){
                                        pri=1;//誰かの優先日付け
                                        if(user_id==priorities[i].user_id){
                                            pri+=1;//自分の優先日付け
                                        }
                                    }
                               }

                               if(itti2==1 || pri==1){//他の人の優先日または予約日
                                calendar += "<td class='disabled other'>" + count + "</td>"
                               }else if(itti2==2 && pri==0){//自分の予約日で自分の優先日ではない
                                   calendar += "<td class='self'><a href='/reserve_edit/" + year + "-" + my_month + "-" + my_count +"'>" + count + "</a></td>"
                               }else if(itti2==2 &&  pri==2){
                                    calendar += "<td class='self pri'><a href='/reserve_edit/" + year + "-" + my_month + "-" + my_count +"'>" + count + "<br>" + "優" + "</a></td>"
                                }else if(pri==2){
                                    calendar += "<td class='pri'><a href='/reserve_edit/" + year + "-" + my_month + "-" + my_count +"'>" + count + "<br>" + "優" + "</a></td>"
                               }else{
                                   calendar += "<td class=''><a href='/reserve_edit/" + year + "-" + my_month + "-" + my_count +"'>" + count + "</a></td>"
                               }

                            };
                        }
                    }
                }
            }
            calendar += "</tr>";
        }
        return calendar;
    }
}

document.addEventListener('DOMContentLoaded',function(){
    if(parseInt(sessionStorage.getItem('month_add'))){
        new Calender('.current-calendar',parseInt(sessionStorage.getItem('month_add')));
        
    }else{
        new Calender('.current-calendar',0);
    }

});
