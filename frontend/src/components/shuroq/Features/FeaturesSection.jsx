import "./featuresSection.css";

export default function FeaturesSection() {
  return (
    <div className="features-section">
      <div className="feature-card">
        <img src="/assets/feature1.png" alt="كل احتياجاتك" />
        <h1>كل احتياجاتك على ميدي بوك</h1>
        <p>
          نوفر لك كل ما تحتاجه لإدارة مواعيدك الطبية بسهولة وراحة.
           من البحث عن الأطباء والخدمات الطبية إلى حجز المواعيد وإدارة جدولك الصحيكل شيء في مكان واحد
. بسرعة وأمان. اجعل تجربتك الطبية أكثر سلاسة مع ميدي بوك، حيث تصبح الرعاية الصحية أقرب إليك من أي وقت مضى.
        </p>
      </div>

      <div className="feature-card">
        <img src="/assets/feature2.png" alt="تقييمات المرضى" />
        <h1>تقييمات حقيقية من المرضى</h1>
        <p>
          تقييمات الدكاترة من مرضى حجزوا على فيزيتا وزاروا الدكتور بالفعل.
        </p>
      </div>

      <div className="feature-card">
        <img src="/assets/feature3.png" alt="حجز مؤكد" />
        <h1>حجزك مؤكد مع دكتورك</h1>
        <p>
          حجزك مؤكد بمجرد اختيارك من المواعيد المتاحة للدكتور.
        </p>
      </div>
    </div>
  );
}
